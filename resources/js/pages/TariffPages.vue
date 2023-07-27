<template>
    <div>
        <div>
            <b-button v-b-modal.modalСreateTariff variant="primary" class="my-2">Добавить тарифный план</b-button>

            <b-modal ref="modalСreateTariff" class="modalСreateTariff" id="modalСreateTariff" size="lg" hide-footer centered
                title="Добавить тарифный план">
                <CreateTariffComponent @getData="getData" @close-modal="closeModalCreateTariff"></CreateTariffComponent>
            </b-modal>
        </div>
        <IndexComponent :fields="fields" :data="data" @getData="getData" :show="show"></IndexComponent>
    </div>
</template>
<script>
import CreateTariffComponent from '../components/Tariff/CreateTariffComponent'
import IndexComponent from '../components/IndexComponent'
export default {
    name: "CardPages",
    components: {
        CreateTariffComponent,
        IndexComponent,
    },

    data() {
        return {
            show: 'tariff',
            data: [],
            fields: [
                {
                    name: 'name',
                    title: 'Название тарифа',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'name',
                },
                {
                    name: 'available_minutes',
                    title: 'Количество минут, мин',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'available_minutes',
                },
                {
                    name: 'sms_count',
                    title: 'Количество смс, смс',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'sms_count'
                },
                {
                    name: 'cost',
                    title: 'Стоимость, руб/мес',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'cost'
                },
                {
                    name: 'actions',
                    title: 'Действие',
                    titleClass: 'text-center',
                },
            ],
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            axios.get("/api/tariffs").then(response => {
                console.log(response.data);
                this.data = response.data;
            });
        },
        closeModalCreateTariff() {
            this.$refs.modalСreateTariff.hide();
        }
    }
}

</script>
<style></style>
