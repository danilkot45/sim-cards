<template>
    <div class="container">
        <h2 class="text-center mb-4">Подробная информация по сим-карте</h2>
        <div class="my-2">
            Imei: <strong>{{ showImei }}</strong>
        </div>
        <div class="my-2">
            Номер телефона: <strong>{{ showPhone }}</strong>
        </div>
        <div class="my-2">
            ФИО клиента: <strong>{{ showFio }}</strong>
        </div>
        <template v-if="showTariffPlanName">
            <div class="my-2">
                Название тарифа: <strong>{{ showTariffPlanName }}</strong>
            </div>
            <h4 class="text-center my-3"> Тарифный план {{ showTariffPlanName }} включает в себя:</h4>
            <div class="my-2">
                Количество минут: <strong>{{ showTariffPlanAvailableMinutes }} мин</strong>
            </div>
            <div class="my-2">
                Количество смс: <strong> {{ showTariffPlanSmsCount }} смс</strong>
            </div>
            <div class="my-2">
                Стоимость: <strong>{{ showTariffPlanCost }} руб/мес</strong>
            </div>
        </template>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id'],
    data() {
        return {
            showImei: null,
            showPhone: null,
            showFio: null,
            showTariffPlanName: null,
            showTariffPlanAvailableMinutes: null,
            showTariffPlanSmsCount: null,
            showTariffPlanCost: null,
        };
    },
    mounted() {
        this.getCard();
    },
    methods: {
        getCard() {
            axios.get(`/api/cards/${this.id}`).then(
                response => {
                    console.log(response);
                    this.showImei = response.data.imei;
                    this.showPhone = response.data.number;
                    this.showFio = response.data.fio;
                    if (response.data.tariff) {
                        this.showTariffPlanName = response.data.tariff.name;
                        this.showTariffPlanAvailableMinutes = response.data.tariff.available_minutes;
                        this.showTariffPlanSmsCount = response.data.tariff.sms_count;
                        this.showTariffPlanCost = response.data.tariff.cost;
                    }
                }
            )
        }
    }
};
</script>

<style scoped>
.container {
    margin: 0 auto;
}

.form-group {
    margin-bottom: 20px;
}
</style>
