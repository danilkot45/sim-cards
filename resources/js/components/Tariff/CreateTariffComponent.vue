<template>
    <div class="container">
        <div class="form-group">
            <label for="name">Название тарифа</label>
            <input type="text" class="form-control" id="name" v-model="name" placeholder="Название тарифа">
            <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
        </div>
        <div class="form-group">
            <label for="available_minutes">Количество минут, мин</label>
            <input type="number" class="form-control" id="available_minutes" v-model="available_minutes"
                placeholder="Введите количество минут">
            <small v-if="errors.available_minutes" class="text-danger">{{ errors.available_minutes[0] }}</small>
        </div>
        <div class="form-group">
            <label for="sms_count">Количество смс, смс</label>
            <input type="number" class="form-control" id="sms_count" v-model="sms_count"
                placeholder="Введите количество смс">
            <small v-if="errors.sms_count" class="text-danger">{{ errors.sms_count[0] }}</small>
        </div>
        <div class="form-group">
            <label for="cost">Стоимость, руб/мес</label>
            <input type="number" class="form-control" id="cost" v-model="cost" placeholder="Введите стоимость">
            <small v-if="errors.cost" class="text-danger">{{ errors.cost[0] }}</small>
        </div>
        <button type="submit" class="btn btn-primary" @click.prevent="addTariff">Отправить</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: null,
            available_minutes: null,
            sms_count: null,
            cost: null,
            errors: {}
        };
    },
    methods: {
        addTariff() {
            this.errors = {};
            axios.post('/api/tariffs', { name: this.name, available_minutes: this.available_minutes, sms_count: this.sms_count, cost: this.cost })
                .then(response => {
                    this.name = null;
                    this.available_minutes = null;
                    this.sms_count = null;
                    this.cost = null;
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
