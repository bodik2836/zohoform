import { ref } from 'vue';
import axios from "axios";

export default function useDealStages() {
    const dealStages = ref([]);

    const getDealStages = async () => {
        let baseUri = window.location.origin;

        try {
            let response = await axios.get(baseUri + '/api/zoho/settings/deal-stages');

            if (response.data.error === 'invalid_code') {
                window.location.href = '/zoho/auth';
            }

            dealStages.value = response.data.stages;
        } catch (e) {
            console.log(e.response)
        }
    }

    return {
        dealStages,
        getDealStages
    }
}
