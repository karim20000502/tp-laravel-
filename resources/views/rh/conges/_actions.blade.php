@if ($conge->statut === 'en_attente')
    <form action="{{ route('rh.conges.approuver', $conge) }}" method="POST" class="d-inline">
        @csrf @method('PATCH')
        <button class="btn btn-sm btn-success" title="Approuver"><i class="bi bi-check-lg"></i></button>
    </form>
    <form action="{{ route('rh.conges.refuser', $conge) }}" method="POST" class="d-inline">
        @csrf @method('PATCH')
        <button class="btn btn-sm btn-danger" title="Refuser"><i class="bi bi-x-lg"></i></button>
    </form>
@endif
