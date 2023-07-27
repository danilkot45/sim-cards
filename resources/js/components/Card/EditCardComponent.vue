<template>
    <div class="container">
        <div class="form-group">
            <label for="imei">IMEI</label>
            <input type="number" class="form-control" id="imei" v-model="editImei" placeholder="Введите imei">
            <small v-if="errors.imei" class="text-danger">{{ errors.imei[0] }}</small>
        </div>
        <div class="form-group">
            <label for="phone">Номер телефона</label>
            <input type="tel" class="form-control" id="phone" v-model="editPhone" placeholder="телефон">
            <small v-if="errors.number" class="text-danger">{{ errors.number[0] }}</small>
        </div>
        <div class="form-group">
            <label for="fullName">ФИО</label>
            <input type="text" class="form-control" id="fio" v-model="editFio" placeholder="Петров Петр Петрович">
            <small v-if="errors.fio" class="text-danger">{{ errors.fio[0] }}</small>
        </div>
        <div class="form-group">
            <label for="tariff_id">Тарифный план</label>
            <select class="form-control" id="tariff_id" v-model="editTariffPlan">
                <option disabled value="">Выберите тарифный план</option>
                <option v-for="tariff in tariffs" :key="tariff.id" :value="tariff.id"> {{ tariff.name }}</option>
            </select>
            <small v-if="errors.tariff_id" class="text-danger">{{ errors.tariff_id[0] }}</small>
        </div>
        <button type="submit" class="btn btn-primary" @click.prevent="editCard">Обновить данные</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id', 'imei', 'phone', 'fio', 'tariffPlan'],
    data() {
        return {
            editImei: null,
            editPhone: null,
            editFio: null,
            editTariffPlan: null,
            tariffs: [],
            errors: {}
        };
    },
    mounted() {
        this.editImei = this.imei;
        this.editPhone = this.phone;
        this.editFio = this.fio;
        this.editTariffPlan = this.tariffPlan;
        this.getTariff();
    },
    methods: {
        getTariff() {
            axios.get('/api/cards/create')
                .then(response => {
                    console.log(response.data);
                    this.tariffs = response.data
                })
        },
        editCard() {
            this.errors = {};
            axios.patch(`/api/cards/${this.id}`, { imei: this.editImei, number: this.editPhone, fio: this.editFio, tariff_id: this.editTariffPlan })
                .then(response => {
                    console.log(response);
                    this.$emit('getData');
                    this.$emit('closeModalEditCard');
                })
                .catch(error => {
                    console.log(error);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error(error);
                    }
                });
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
