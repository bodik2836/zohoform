import { ref } from 'vue';
import axios from "axios";
import { useRouter } from 'vue-router';

export default function useZohoForm() {
    const zohoForm = ref([]);
    const router = useRouter();

    const notifications = ref([]);

    const storeZohoForm = async (data) => {
        notifications.value = [];
        let baseUri = window.location.origin;
        try {
            let response = await axios.post(baseUri + '/api/zoho/form', data);

            notifications.value = response.data;

            await router.push({ name: 'zoho.form.index' });
        } catch (e) {
            if (e.response.status === 422) {
                notifications.value = e.response.data.errors;
            }
        }

    }

    return {
        notifications,
        zohoForm,
        storeZohoForm
    }
}
