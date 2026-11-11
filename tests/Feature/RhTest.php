<?php

namespace Tests\Feature;

use App\Models\Conge;
use App\Models\Departement;
use App\Models\Employe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RhTest extends TestCase
{
    use RefreshDatabase;

    public function test_les_pages_principales_s_affichent(): void
    {
        $employe = Employe::factory()->create();
        Conge::factory()->for($employe)->create();

        foreach (['/rh', '/rh/employes', '/rh/departements', '/rh/conges', '/rh/conges/create', '/rh/employes/create',
            "/rh/employes/{$employe->id}", "/rh/departements/{$employe->departement_id}", "/rh/employes/{$employe->id}/edit"] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_creer_un_employe(): void
    {
        $d = Departement::factory()->create();

        $this->post('/rh/employes', [
            'matricule' => 'EMP0001', 'nom' => 'Alaoui', 'prenom' => 'Sara', 'cin' => 'AB123456',
            'email' => 'sara@example.com', 'genre' => 'F', 'date_embauche' => '2024-01-15',
            'poste' => 'Comptable', 'salaire' => 8000, 'statut' => 'actif', 'departement_id' => $d->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('employes', ['matricule' => 'EMP0001', 'departement_id' => $d->id]);
    }

    public function test_validation_employe(): void
    {
        $this->post('/rh/employes', [])->assertSessionHasErrors(['matricule', 'nom', 'email', 'departement_id']);
    }

    public function test_departement_avec_employes_non_supprimable(): void
    {
        $e = Employe::factory()->create();

        $this->delete("/rh/departements/{$e->departement_id}")->assertSessionHas('error');
        $this->assertDatabaseHas('departements', ['id' => $e->departement_id]);
    }

    public function test_demande_et_approbation_de_conge(): void
    {
        $e = Employe::factory()->create();

        $this->post('/rh/conges', [
            'employe_id' => $e->id, 'type' => 'annuel',
            'date_debut' => now()->startOfYear()->addDays(10)->toDateString(),
            'date_fin' => now()->startOfYear()->addDays(14)->toDateString(),
        ])->assertRedirect();

        $conge = Conge::firstOrFail();
        $this->assertSame('en_attente', $conge->statut);

        $this->patch("/rh/conges/{$conge->id}/approuver")->assertSessionHas('status');
        $this->assertSame('approuve', $conge->fresh()->statut);
        $this->assertSame(5, $e->joursCongeAnnuelPris());
    }

    public function test_chevauchement_de_conge_refuse(): void
    {
        $e = Employe::factory()->create();
        Conge::factory()->for($e)->create(['date_debut' => '2026-03-01', 'date_fin' => '2026-03-05', 'statut' => 'approuve']);

        $this->post('/rh/conges', [
            'employe_id' => $e->id, 'type' => 'maladie', 'date_debut' => '2026-03-04', 'date_fin' => '2026-03-06',
        ])->assertSessionHasErrors('date_debut');
    }

    public function test_solde_insuffisant_bloque_l_approbation(): void
    {
        $e = Employe::factory()->create();
        $conge = Conge::factory()->for($e)->create([
            'type' => 'annuel', 'statut' => 'en_attente',
            'date_debut' => now()->startOfYear(), 'date_fin' => now()->startOfYear()->addDays(Conge::SOLDE_ANNUEL),
        ]);

        $this->patch("/rh/conges/{$conge->id}/approuver")->assertSessionHas('error');
        $this->assertSame('en_attente', $conge->fresh()->statut);
    }
}
