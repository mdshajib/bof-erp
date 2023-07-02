<div>
    @section('page-title')
        {{ __('Profile') }}
    @endsection

    @section('header')
        <x-common.header title="{{ __('Profile') }}">

        </x-common.header>
    @endsection
    <div class="row">
        <div class="col-xl-6 col-md-6 vol-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Profile</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  {{ $activeTab == 'profile' ? 'active' : '' }}" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="true" wire:click="stepActive(1)">
                                <span class="d-block d-sm-none"> <i class="mdi mdi-face-profile font-size-16 align-middle1 me-1"></i> </span>
                                <span class="d-none d-sm-block">Profile Information</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab =='password' ? 'active' : '' }}" data-bs-toggle="tab" href="#update_password" role="tab" aria-selected="true" wire:click="stepActive(2)">
                                <span class="d-block d-sm-none"></span>
                                <span class="d-none d-sm-block">Update Password</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane {{ $activeTab =='profile' ? 'active' : '' }}" id="profile">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="mb-3">
                                    <label class="form-label " for="first_name">First Name</label>
                                    <x-form.input id="first_name" wire:model.defer="first_name" placeholder="{{ __('Firist Name') }}" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label " for="last_name">Last Name</label>
                                    <x-form.input id="last_name" wire:model.defer="last_name" placeholder="{{ __('Last Name') }}" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label " for="email">Email</label>
                                    <x-form.input type="email" id="email" wire:model.defer="email" placeholder="{{ __('Email') }}" />
                                </div>


                                <div class="mb-3">
                                    <x-form.select id="lang" wire:model.defer="lang" placeholder="{{ __('Lang') }}">
                                        <option value="en">English</option>
                                        <option value="bn">বাংলা</option>
                                    </x-form.select>
                                  </div>
                                <button wire:loading.attr="disabled" class="btn btn-primary" wire:click.prevent="updateProfile">Update Profile</button>
                            </div>

                        </div>
                        <div class="tab-pane {{ $activeTab =='password' ? 'active' : '' }}" id="update_password">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="mb-3">
                                    <label class="form-label" for="current_password">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" placeholder="Current Password" wire:model.defer="current_password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="New Password" wire:model="password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" wire:model="password_confirmation">
                                </div>
                                <div class="col-12 pl-0">
                                    <div class="form-group pl-0">
                                        <button type="submit" class="btn btn-primary" wire:click.prevent="updatePassword">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-notify/>
</div>
