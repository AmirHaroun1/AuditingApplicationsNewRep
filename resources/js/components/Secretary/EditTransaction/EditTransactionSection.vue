<template>
<div>
    <v-tabs v-model="tab" background-color="primary" centered dark icons-and-text>
        <v-tab @click="ActivePane = 'بيانات المعاملة' ">
            {{$t('transactionInfo')}}
            <v-icon left>fa fa-star-o</v-icon>
        </v-tab>

        <v-tab @click="ActivePane = 'الملفات' ">
            {{$t('files')}}
            <v-icon left>fa fa-files-o</v-icon>
        </v-tab>

        <v-tab @click="ActivePane = 'الدفع' ">
            {{$t('payment')}}
            <v-icon left>fa fa-money</v-icon>
        </v-tab>
    </v-tabs>
    <div class="tab-content">
        <transition name="fade" class="tab-pane fade in show"  transition="fab-transition" v-if="ActivePane=='بيانات المعاملة'">
            <edit-transaction-data :Agent="Agent"></edit-transaction-data>
        </transition>
        <div class="tab-pane fade in show" v-else-if="ActivePane=='الملفات'">
            <documents-management-section :Transaction="Transaction"></documents-management-section>
        </div>
        <div class="tab-pane fade in show" v-else-if="ActivePane=='الدفع'">
            <payment-details-form :Transaction="Transaction"></payment-details-form>
        </div>
    </div>

</div>
</template>

<script>
export default {
    name: "SecretaryEditTransaction.vue",
    props: {
        'Transaction': Object,
    },
    data() {
        return {

            ActivePane: 'بيانات المعاملة',
            tab: '',
            Institution: '',
            Agent: null,
            MainTradeRegister: '',
            BranchedTradeRegisters: '',
            Documents: '',
            reviser: '',
            revisingManager: '',
        }
    },
    created() {
        this.Institution = this.Transaction.institution;
        this.Agent = this.Transaction.institution.agent;
        this.MainTradeRegister = this.Transaction.institution.main_trade_register;
        this.BranchedTradeRegisters = this.Transaction.institution.branched_trade_register;
        this.Documents = this.Transaction.documentations;
        this.reviser = this.Transaction.reviser;
        this.revisingManager = this.Transaction.revising_manager;
    },

}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
