<template>
    <div class="container">
        <div class="form-group">
            <label for="name">Название тарифа</label>
            <input type="text" class="form-control" id="name" v-model="editName" placeholder="Название тарифа">
            <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
        </div>
        <div class="form-group">
            <label for="available_minutes">Количество минут, мин</label>
            <input type="number" class="form-control" id="available_minutes" v-model="editAvailableMinutes"
                placeholder="Введите количество минут">
            <small v-if="errors.available_minutes" class="text-danger">{{ errors.available_minutes[0] }}</small>
        </div>
        <div class="form-group">
            <label for="sms_count">Количество смс, смс</label>
            <input type="number" class="form-control" id="sms_count" v-model="editSmsCount"
                placeholder="Введите количество смс">
            <small v-if="errors.sms_count" class="text-danger">{{ errors.sms_count[0] }}</small>
        </div>
        <div class="form-group">
            <label for="cost">Стоимость, руб/мес</label>
            <input type="number" class="form-control" id="cost" v-model="editCost" placeholder="Введите стоимость">
            <small v-if="errors.cost" class="text-danger">{{ errors.cost[0] }}</small>
        </div>
        <button type="submit" class="btn btn-primary" @click.prevent="editTariff">Отправить</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id', 'nameTariff', 'availableMinutes', 'smsCount', 'cost'],
    data() {
        return {
            editName: null,
            editAvailableMinutes: null,
            editSmsCount: null,
            editCost: null,
            errors: {}
        };
    },
    mounted() {
        this.editName = this.nameTariff;
        this.editAvailableMinutes = this.availableMinutes;
        this.editSmsCount = this.smsCount;
        this.editCost = this.cost;
    },
    methods: {
        editTariff() {
            this.errors = {};
            axios.patch(`/api/tariffs/${this.id}`, { name: this.editName, available_minutes: this.editAvailableMinutes, sms_count: this.editSmsCount, cost: this.editCost })
                .then(response => {
                    console.log(response);
                    this.$emit('getData');
                    this.$emit('closeModalEditTariff');
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
