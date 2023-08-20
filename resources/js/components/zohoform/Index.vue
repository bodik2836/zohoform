<script setup>

</script>

<template>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Account & Deal</h4>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="mt-5 mt-lg-4">
                                <form method="post" action="{{ route('zoho.form.store') }}" data-bitwarden-watching="1">
                                    @csrf
                                    <div class="row mb-4">
                                        <label for="horizontal-Fullname-input" class="col-sm-3 col-form-label">Account Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('Account_Name') is-invalid @enderror" data-parsley-minlength="6" name="Account_Name" value="{{ old('Account_Name') }}">
                                            @error('Account_Name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Account Phone</label>
                                        <div class="col-sm-9">
                                            <input type="tel" class="form-control" name="Phone" value="{{ old('Phone') }}">
                                            @error('Phone')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Account Website</label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" name="Website" value="{{ old('Website') }}">
                                            @error('Website')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Deal Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="Deal_Name" value="{{ old('Deal_Name') }}">
                                            @error('Deal_Name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Deal Stage</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" name="Stage">
                                                @foreach($stages as $stage)
                                                <option value="{{ $stage['id'] }}">{{ $stage['display_label'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('Stage')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Closing Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="Closing_Date" value="{{ old('Closing_Date') }}">
                                            @error('Closing_Date')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row justify-content-end">
                                        <div class="col-sm-9">
                                            <div class="d-flex flex-wrap gap-3">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
                                                <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
