<template>
    <div class="container">
        <div class="form-group">
            <label for="imei">IMEI</label>
            <input type="number" class="form-control" id="imei" v-model="imei" placeholder="Введите imei">
            <small v-if="errors.imei" class="text-danger">{{ errors.imei[0] }}</small>
        </div>
        <div class="form-group">
            <label for="phone">Номер телефона</label>
            <input type="tel" class="form-control" id="phone" v-model="phone" placeholder="телефон">
            <small v-if="errors.number" class="text-danger">{{ errors.number[0] }}</small>
        </div>
        <div class="form-group">
            <label for="fullName">ФИО</label>
            <input type="text" class="form-control" id="fio" v-model="fio" placeholder="Петров Петр Петрович">
            <small v-if="errors.fio" class="text-danger">{{ errors.fio[0] }}</small>
        </div>
        <div class="form-group">
            <label for="tariff_id">Тарифный план</label>
            <select class="form-control" id="tariff_id" v-model="tariffPlan">
                <option disabled value="">Выберите тарифный план</option>
                <option v-for="tariff in tariffs" :key="tariff.id" :value="tariff.id"> {{ tariff.name }}</option>
            </select>
            <small v-if="errors.tariff_id" class="text-danger">{{ errors.tariff_id[0] }}</small>
        </div>
        <button type="submit" class="btn btn-primary" @click.prevent="addCard">Отправить</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            tariffs: [],
            imei: null,
            phone: null,
            fio: null,
            tariffPlan: null,
            errors: {}
        };
    },
    mounted() {
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
        addCard() {
            this.errors = {};
            axios.post('/api/cards', { imei: this.imei, number: this.phone, fio: this.fio, tariff_id: this.tariffPlan })
                .then(response => {
                    this.imei = null;
                    this.phone = null;
                    this.fio = null;
                    this.tariffPlan = null;
                    this.$emit('getData');
                    this.$emit('close-modal');
                })
                .catch(error => {
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
