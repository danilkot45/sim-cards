<template>
    <div>
        <div>
            <b-button v-b-modal.modalСreateCard variant="primary" class="my-2">Добавить Sim-card</b-button>

            <b-modal ref="modalСreateCard" class="modalСreateCard" id="modalСreateCard" size="lg" hide-footer centered
                title="Добавить Sim-карту">
                <CreateCardComponent @getData="getData" @close-modal="closeModalCreate"></CreateCardComponent>
            </b-modal>
        </div>
        <IndexComponent :fields="fields" :data="data" @getData="getData" :show="show"></IndexComponent>
    </div>
</template>
<script>
import moment from 'moment' // for birthday field
import CreateCardComponent from '../components/Card/CreateCardComponent'
import IndexComponent from '../components/IndexComponent'
export default {
    name: "CardPages",
    components: {
        CreateCardComponent,
        IndexComponent,
    },

    data() {
        return {
            show: 'card',
            data: [],
            fields: [
                {
                    name: 'imei',
                    title: 'Imei',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'imei',
                },
                {
                    name: 'number',
                    title: 'Номер телефона',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'number',
                },
                {
                    name: 'fio',
                    title: 'ФИО',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'fio'
                },
                {
                    name: 'tariff.name',
                    title: 'Тарифный план',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    sortField: 'tariff_id'
                },
                {
                    name: 'created_at',
                    title: 'Дата регистрации',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    formatter: (value, key, item) => {
                        return moment(value).format('DD-MM-YYYY/H:mm:ss');
                    },
                    sortField: 'created_at',

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
            axios.get("/api/cards").then(response => {

                console.log(response.data);
                this.data = response.data;
            });
        },
        closeModalCreate() {
            this.$refs.modalСreateCard.hide();
        }
    }
}

</script>
<style></style>
