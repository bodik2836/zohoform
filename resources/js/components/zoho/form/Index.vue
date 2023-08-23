<script>
import {onMounted, reactive} from "vue";
import useZohoForm from '../../../composables/zoho_form.js';
import useDealStages from '../../../composables/deal_stages.js';

export default {
    setup() {
        const form = reactive({
            'Account_Name':'',
            'Phone':'',
            'Website':'',
            'Deal_Name':'',
            'Stage':'',
            'Closing_Date':'',
        });

        const { notifications, storeZohoForm } = useZohoForm();
        const { dealStages, getDealStages } = useDealStages();

        onMounted(getDealStages);

        const saveForm = async () => {
            await storeZohoForm({...form});
            clearForm();
        }

        const clearError = (fieldName) => {
            if (notifications.value[fieldName])
                notifications.value[fieldName][0] = '';
        }

        const clearForm = () => {
            form.Account_Name = '';
            form.Phone = '';
            form.Website = '';
            form.Deal_Name = '';
            form.Stage = '';
            form.Closing_Date = '';
        }

        return {
            form,
            notifications,
            saveForm,
            dealStages,
            clearForm,
            clearError
        }
    },
}

</script>

<template>
<div class="container">
    <div class="mb-3">
        <template v-if="notifications">
            <template v-for="item in notifications">
                <div v-if="item.status === 'success'" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ item.successMessage }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </template>
            <template v-for="item in notifications">
                <div v-if="item.status === 'error'" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ item.errorMessage }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </template>
        </template>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Account & Deal</h4>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="mt-5 mt-lg-4">
                                <form @submit.prevent="saveForm" method="post" data-bitwarden-watching="1">
                                    <div class="row mb-4">
                                        <label for="Account_Name" class="col-sm-3 col-form-label">
                                            Account Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="Account_Name"
                                                id="Account_Name"
                                                v-model="form.Account_Name"
                                                @focus="clearError('Account_Name')"
                                            >
                                            <span v-if="notifications"
                                                  class="text-danger"
                                            >
                                                {{ 'Account_Name' in notifications ? notifications['Account_Name'][0] : '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="Phone" class="col-sm-3 col-form-label">Account Phone</label>
                                        <div class="col-sm-9">
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="Phone"
                                                id="Phone"
                                                v-model="form.Phone"
                                                @focus="clearError('Phone')"
                                            >
                                            <span v-if="notifications"
                                                  class="text-danger"
                                            >
                                                {{ 'Phone' in notifications ? notifications['Phone'][0] : '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="Website" class="col-sm-3 col-form-label">Account Website</label>
                                        <div class="col-sm-9">
                                            <input
                                                type="url"
                                                class="form-control"
                                                name="Website"
                                                id="Website"
                                                v-model="form.Website"
                                                @focus="clearError('Website')"
                                            >
                                            <span v-if="notifications"
                                                  class="text-danger"
                                            >
                                                {{ 'Website' in notifications ? notifications['Website'][0] : '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="Deal_Name" class="col-sm-3 col-form-label">
                                            Deal Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="Deal_Name"
                                                id="Deal_Name"
                                                v-model="form.Deal_Name"
                                                @focus="clearError('Deal_Name')"
                                            >
                                            <span v-if="notifications"
                                                  class="text-danger"
                                            >
                                                {{ 'Deal_Name' in notifications ? notifications['Deal_Name'][0] : '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="Stage" class="col-sm-3 col-form-label">
                                            Deal Stage <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="form-select" name="Stage" id="Stage" v-model="form.Stage" @focus="clearError('Stage')">
                                                <option disabled value="">--- select stage ----</option>
                                                <option
                                                    v-for="item in dealStages"
                                                    :key="item.id"
                                                    :value="item.id"
                                                >
                                                    {{ item.display_label }}
                                                </option>
                                            </select>
                                            <span v-if="notifications"
                                                  class="text-danger"
                                            >
                                                {{ 'Stage' in notifications ? notifications['Stage'][0] : '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="Closing_Date" class="col-sm-3 col-form-label">
                                            Closing Date <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input
                                                type="date"
                                                class="form-control"
                                                name="Closing_Date"
                                                id="Closing_Date"
                                                v-model="form.Closing_Date"
                                                @focus="clearError('Closing_Date')"
                                            >
                                            <span v-if="notifications"
                                                  class="text-danger"
                                            >
                                                {{ 'Closing_Date' in notifications ? notifications['Closing_Date'][0] : '' }}
                                            </span>
                                        </div>
                                    </div>


                                    <div class="row justify-content-end">
                                        <div class="col-sm-9">
                                            <div class="d-flex flex-wrap gap-3">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
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
