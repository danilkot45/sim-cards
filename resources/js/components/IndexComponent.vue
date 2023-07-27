<template>
    <div>
        <template v-if="show == 'card'">
            <b-modal ref="modalEditCard" class="modalEditCard" id="modalEditCard" size="lg" hide-footer centered
                title="Редактировать Sim-карту">
                <EditCardComponent :id="id" :imei="imei" :phone="phone" :fio="fio" :tariffPlan="tariffPlan"
                    @closeModalEditCard="closeModalEditCard" @getData="getData"></EditCardComponent>
            </b-modal>
            <b-modal ref="modalShowCard" class="modalShowCard" id="modalShowCard" size="lg" hide-footer centered
                title="Просмотр сим-карты">
                <ShowCardComponent :id="id"></ShowCardComponent>
            </b-modal>
        </template>
        <template v-if="show == 'tariff'">
            <b-modal ref="modalEditTariff" class="modalEditTariff" id="modalEditTariff" size="lg" hide-footer centered
                title="Редактировать Sim-карту">
                <EditTariffComponent :id="id" :nameTariff="nameTariff" :availableMinutes="availableMinutes"
                    :smsCount="smsCount" :cost="cost" @closeModalEditTariff="closeModalEditTariff" @getData="getData">
                </EditTariffComponent>
            </b-modal>
        </template>
        <vuetable ref="vuetable" class='table table-striped table-bordered' :api-mode="false" :fields="fields"
            :per-page="perPage" :data-manager="dataManager" pagination-path="pagination"
            @vuetable:pagination-data="onPaginationData">
            <div slot="actions" slot-scope="props">
                <template v-if="show == 'card'">
                    <b-button v-b-modal.modalShowCard variant="primary" class="btn btn-sm mb-1 btn-block"
                        @click="onActionClicked('showCard', props.rowData)">
                        <span>Подробнее</span>
                    </b-button>
                    <b-button v-b-modal.modalEditCard variant="warning" class="btn btn-sm mb-1 btn-block"
                        @click="onActionClicked('editCard', props.rowData)">
                        <span> Редактировать </span>
                    </b-button>
                    <button class="btn btn-danger btn-sm mb-1 btn-block"
                        @click="onActionClicked('deleteCard', props.rowData)">
                        <span>Удалить</span>
                    </button>
                </template>
                <template v-if="show == 'tariff'">
                    <b-button v-b-modal.modalEditTariff variant="warning" class="btn btn-sm mb-1 btn-block"
                        @click="onActionClicked('editTariff', props.rowData)">
                        <span> Редактировать </span>
                    </b-button>
                    <button class="btn btn-danger btn-sm mb-1 btn-block"
                        @click="onActionClicked('deleteTariff', props.rowData)">
                        <span>Удалить</span>
                    </button>
                </template>
            </div>
        </vuetable>
        <div style="padding-top:10px">
            <vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>

            <vuetable-pagination ref="pagination" :css="paginationCss"
                @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
        </div>
    </div>
</template>

<script>
import Vuetable from "vuetable-2";
import VuetablePagination from "vuetable-2/src/components/VuetablePagination";
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import EditCardComponent from './Card/EditCardComponent'
import ShowCardComponent from './Card/ShowCardComponent'
import EditTariffComponent from './Tariff/EditTariffComponent'
import axios from "axios";
import _ from "lodash";

export default {
    name: "IndexComponent",
    props: ['data', 'fields', 'show'],
    components: {
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo,
        EditCardComponent,
        ShowCardComponent,
        EditTariffComponent,
    },

    data() {
        return {
            paginationCss: {
                wrapperClass: 'pagination',
                activeClass: 'btn-primary',
                disabledClass: 'disabled',
                pageClass: 'btn btn-border',
                linkClass: 'btn btn-border',
                icons: {
                    first: '',
                    prev: '',
                    next: '',
                    last: '',
                }
            },
            perPage: 5,
            id: null,
            imei: null,
            phone: null,
            fio: null,
            tariffPlan: null,
            nameTariff: null,
            availableMinutes: null,
            smsCount: null,
            cost: null,

        };
    },
    watch: {
        data(newVal, oldVal) {
            this.$refs.vuetable.refresh();
        }
    },
    methods: {
        getData() {
            this.$emit('getData');
        },
        closeModalEditCard() {
            this.$refs.modalEditCard.hide();
        },
        closeModalEditTariff() {
            this.$refs.modalEditTariff.hide();
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
            this.$refs.paginationInfo.setPaginationData(paginationData)
        },
        onChangePage(page) {
            console.log('page', page);
            this.$refs.vuetable.changePage(page);
        },
        dataManager(sortOrder, pagination) {
            if (this.data.length < 1) return {
                pagination: {}
            };

            let local = this.data;

            // sortOrder can be empty, so we have to check for that as well
            if (sortOrder.length > 0) {
                console.log("orderBy:", sortOrder[0].sortField, sortOrder[0].direction);
                local = _.orderBy(
                    local,
                    sortOrder[0].sortField,
                    sortOrder[0].direction
                );
            }

            pagination = this.$refs.vuetable.makePagination(
                local.length,
                this.perPage
            );
            let from = pagination.from - 1;
            let to = from + this.perPage;


            return {
                pagination: pagination,
                data: _.slice(local, from, to)
            };
        },
        onActionClicked(action, data) {
            if (action == 'showCard') {
                this.id = data.id;
            }
            if (action == 'editCard') {
                this.id = data.id;
                this.imei = data.imei;
                this.phone = data.number;
                this.fio = data.fio;
                this.tariffPlan = data.tariff_id;
            }
            if (action == 'deleteCard') {
                axios.delete(`/api/cards/${data.id}`).then(response => {
                    this.$emit('getData');
                });
            }
            if (action == 'editTariff') {
                this.id = data.id;
                this.nameTariff = data.name;
                this.availableMinutes = data.available_minutes;
                this.smsCount = data.sms_count;
                this.cost = data.cost;
                console.log(this.id, this.nameTariff, this.availableMinutes, this.smsCount, this.cost)
            }
            if (action == 'deleteTariff') {
                console.log(data);
                axios.delete(`/api/tariffs/${data.id}`).then(response => {
                    this.$emit('getData');
                });
            }
        }
    }
};
</script>
<style>
table.vuetable {
    margin: 0 auto;
}

.vuetable .vuetable-th-slot-actions {
    width: 200px;
}
</style>
