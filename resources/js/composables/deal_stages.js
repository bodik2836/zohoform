import { ref } from 'vue';
import axios from "axios";

export default function useDealStages() {
    const dealStages = ref([]);
    const dealStagesErrors = ref([]);

    const getDealStages = async () => {
        let baseUri = window.location.origin;

        try {
            let response = await axios.get(baseUri + '/api/zoho/settings/deal-stages');
            dealStages.value = response.data;
        } catch (e) {
            console.log(e.response)
        }
    }

    return {
        dealStages,
        getDealStages
    }
}
