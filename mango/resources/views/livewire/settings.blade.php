<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 ">
        <div class="card mb-4 ">
            <div class="card-body">
                <form wire:submit="add">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <input type="text" wire:model="name" class="form-control form-control-alternative form-control-sm" placeholder="Protected name">
                            </div>
                            @error('name') <div class="text-danger text-xs mb-2">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <div class="col-12">
                                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Protected containers</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Added at</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($protected as $protectedName)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0" style="padding-left: 1rem;">{{ $protectedName->getName() }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $protectedName->getDate() }}</p>
                                    </td>

                                    <td class="text-end">
                                        <button wire:click="delete('{{ $protectedName->getName() }}')"
                                                wire:confirm="Are you sure you want to delete protected name {{ $protectedName->getName() }}?"
                                                type="button" class="btn btn-outline-default btn-sm mb-0">delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
