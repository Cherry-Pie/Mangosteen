<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            @if(!is_null($beforeFailureCode))
                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">
                        <strong>before.sh <span class="{{ $beforeFailureCode ? 'text-danger' : 'text-success' }}">(exit code: {{ $beforeFailureCode }})</span></strong>
                        @foreach($beforeOutput as $line)
                            <br>{{ $line }}
                        @endforeach
                    </span>
                    <button wire:click="flushBeforeOutput()" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(!is_null($dockerFailureCode))
                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">
                        <strong>docker <span class="{{ $dockerFailureCode ? 'text-danger' : 'text-success' }}">(exit code: {{ $dockerFailureCode }})</span></strong>
                        @foreach($dockerOutput as $line)
                            <br>{{ $line }}
                        @endforeach
                    </span>
                    <button wire:click="flushDockerOutput()" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(!is_null($afterFailureCode))
                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">
                        <strong>after.sh <span class="{{ $afterFailureCode ? 'text-danger' : 'text-success' }}">(exit code: {{ $afterFailureCode }})</span></strong>
                        @foreach($afterOutput as $line)
                            <br>{{ $line }}
                        @endforeach
                    </span>
                    <button wire:click="flushAfterOutput()" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

        </div>
    </div>

    <div class="row">
        <div class="col-12 ">
            <div class="card mb-4 ">
                <div class="card-body">
                    <form wire:submit="add">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <input type="text" wire:model="name" class="form-control form-control-alternative form-control-sm" placeholder="Container name">
                                </div>
                                @error('name') <div class="text-danger text-xs mb-2">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <input type="text" wire:model="image" class="form-control form-control-alternative form-control-sm" placeholder="Container image">
                                </div>
                                @error('image') <div class="text-danger text-xs mb-2">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" wire:model="virtualhost" placeholder="Virtual host" class="form-control form-control-alternative form-control-sm" >
                                    <span class="input-group-text form-control-alternative form-control-sm">.{{ config('mango.mangosteen_domain') }}</span>
                                </div>
                                @error('virtualhost') <div class="text-danger text-xs mb-2">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" wire:model="letsencrypthost" placeholder="Letsencrypt host" class="form-control form-control-alternative form-control-sm" >
                                    <span class="input-group-text form-control-alternative form-control-sm">.{{ config('mango.mangosteen_domain') }}</span>
                                </div>
                                @error('letsencrypthost') <div class="text-danger text-xs mb-2">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <input type="number" wire:model="virtualport" class="form-control form-control-alternative form-control-sm" placeholder="Virtual port">
                                </div>
                                @error('virtualport') <div class="text-danger text-xs mb-2">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 pull-right">
                                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th>
                                    <input wire:model.live="search" class="form-control form-control-sm" type="text" placeholder="Search">
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Names</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">State</th>
                                <th class="text-secondary opacity-7">
                                </th>
                            </tr>
                            </thead>
                            <tbody wire:poll.10s>

                            @foreach ($containers as $container)
                                <tr wire:key="{{ $container['ID'] }}">


                                    <td class="align-middle  text-sm">
                                        {{ $container['ID'] }}
                                    </td>
                                    <td class="align-middle  text-sm">
                                        {{ $container['Names'] }}
                                    </td>
                                    <td class="align-middle  text-sm">
                                        {{ $container['Image'] }}
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-1">
                                            <span class="badge badge-sm bg-gradient-{{ strtolower($container['State']) }}">{{ $container['State'] }}</span>
                                        </p>
                                        <p class="text-xs text-secondary mb-0">{{ $container['Status'] }}</p>
                                    </td>

                                    <td class="align-middle">
                                        <button wire:click="stop('{{ $container['ID'] }}')"
                                                wire:confirm="Are you sure you want to stop {{ $container['Names'] }}?"
                                                type="button" class="btn btn-outline-default btn-sm mb-0">stop</button>
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
</div>
