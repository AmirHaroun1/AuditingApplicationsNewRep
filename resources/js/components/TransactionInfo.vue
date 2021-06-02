<template>
<div style="margin-top: 20px">
    <v-container>
        <v-card style="padding:25px">
            <v-card-title class="mb-3">
                <span class="mr-3 ml-3">{{ $t("transactionsData") }}</span>
            </v-card-title>
            <div class="row">
                <div class="box-body">
                    <!------ رقم السجل ------>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field label="رقم السجل الرئيسي" outlined v-model="
                                        Transaction.MainTradeRegisterNumber
                                    " type="number" hide-details disabled></v-text-field>
                        </v-col>
                    </v-row>
                    <!------ تاريخ السجل ------>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-menu v-if="
                                        Transaction.institution
                                            .main_trade_register
                                    " v-model="main_datePicker" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field hide-details disabled outlined label="تاريخ السجل الرئيسى" append-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" v-model="
                                                Transaction.institution
                                                    .main_trade_register.date
                                            "></v-text-field>
                                </template>
                                <v-date-picker v-model="
                                            Transaction.institution
                                                .main_trade_register.date
                                        " @input="main_datePicker = false"></v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <!------ مكان اصدار ------>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field v-if="
                                        Transaction.institution
                                            .main_trade_register
                                    " v-model="
                                        Transaction.institution
                                            .main_trade_register
                                            .production_place
                                    " label="مكان اصدار السجل الرئيسى" outlined hide-details disabled></v-text-field>
                        </v-col>
                    </v-row>

                    <hr />
                    <v-row id="CompanyInformation">
                        <!------ أسم المنشأة ------>
                        <v-col cols="12" md="6">
                            <v-text-field v-if="Transaction.institution" v-model="Transaction.institution.name" label="أسم المنشأة" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ أسم المنشأة/. ------>
                        <!------ رقم المنشأة ------>
                        <v-col cols="12" md="6">
                            <v-text-field v-if="Transaction.institution" v-model="Transaction.institution.name" label="رقم المنشأة" outlined type="number" hide-details disabled></v-text-field>
                        </v-col>
                        <!------ رقم المنشأة/. ------>
                        <!------ الكيان القانوني ------>
                        <v-col md="3">
                            <v-text-field v-if="Transaction.institution" v-model="
                                        Transaction.institution.legal_entity
                                    " label="الكيان القانوني" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ الكيان القانوني/. ------>
                        <!------ اهتمامات الملاك ------>
                        <v-col md="3">
                            <v-text-field v-if="Transaction.institution" v-model="
                                        Transaction.institution.angel_interests
                                    " label="اهتمامات الملاك" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ اهتمامات الملاك/. ------>
                        <!------ طبيعة ملكية المنشأة وكيفية تمويلها ------>
                        <v-col md="3">
                            <v-text-field v-model="Transaction.institution.nature" label="طبيعة ملكية المنشأة وكيفية تمويلها" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ طبيعة ملكية المنشأة وكيفية تمويلها/. ------>
                        <!------ تقويم العام المالي للمنشأة ------>
                        <v-col md="3">
                            <v-text-field v-model="Transaction.institution.date_type" label="تقويم العام المالي للمنشأة" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ تقويم العام المالي للمنشأة/. ------>
                        <!------ نشاط المنشأة ------>
                        <v-col md="9">
                            <v-textarea v-model="
                                        Transaction.institution
                                            .business_activity
                                    " rows="6" outlined hide-details label="نشاط المنشأة" disabled></v-textarea>
                        </v-col>
                        <!------ نشاط المنشأة/. ------>
                        <!------ عنوان المنشأة ------>
                        <v-col md="4">
                            <v-text-field v-model="Transaction.institution.address" label="العنوان" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ عنوان المنشأة./ ------>
                        <!------ الرقم المميز لدى هيئة الذكاة ------>
                        <v-col md="4">
                            <v-text-field v-model="
                                        Transaction.institution.charity_num
                                    " label="الرقم المميز لدى هيئة الذكاة" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ الرقم المميز لدى هيئة الذكاة/. ------>
                        <!------ رقم الضريبة المضافة ------>
                        <v-col md="4">
                            <v-text-field v-model="
                                        Transaction.institution.extra_tax_num
                                    " label="رقم الضريبة المضافة" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <!------ رقم الضريبة المضافة/> ------>
                    </v-row>

                    <hr />
                    <!------ تاريخ انتهاء السجل ------>
                    <v-row>
                        <v-col md="6">
                            <v-menu v-model="finish_reservation" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field hide-details outlined label="تاريخ انتهاء السجل" append-icon="mdi-calendar" readonly disabled v-bind="attrs" v-on="on" v-model="
                                                Transaction.institution
                                                    .main_trade_register.EndDate
                                            "></v-text-field>
                                </template>
                                <v-date-picker v-model="
                                            Transaction.institution
                                                .main_trade_register.EndDate
                                        " @input="finish_reservation = false"></v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <!------ تاريخ انتهاء السجل/. ------>
                    <!------   السنة المالية ------>
                    <v-row>
                        <v-col md="6">
                            <v-text-field type="number" v-model="Transaction.financial_year" label="السنة المالية" outlined hide-details disabled></v-text-field>
                        </v-col>
                    </v-row>
                    <!------   السنة المالية/. ------>
                    <!------   الفترة المالية ------>
                    <v-row>
                        <v-col md="6">
                            <v-text-field v-model="Transaction.financial_period" label="الفترة المالية" outlined hide-details disabled></v-text-field>
                        </v-col>
                    </v-row>
                    <!------   الفترة المالية/. ------>
                    <!------ بداية / نهاية  السنة المالية ------>
                    <v-row>
                        <v-col md="6">
                            <v-text-field v-model="Transaction.start_financial_year" label="بداية السنة المالية" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <v-col md="6">
                            <v-text-field v-model="Transaction.end_financial_year" label="نهاية السنة المالية" outlined hide-details disabled></v-text-field>
                        </v-col>
                    </v-row>

                    <!------ بداية / نهاية  السنة المالية/. ------>
                    <div v-if="
                                Transaction.institution.branched_trade_register
                                    .length
                            ">
                        <v-row v-for="register in Transaction.institution
                                    .branched_trade_register" :key="register">
                            <v-col md="3">
                                <v-text-field label="رقم السجل" type="number" v-model="register.number" outlined hide-details disabled></v-text-field>
                            </v-col>
                            <v-col md="3">
                                <v-text-field label="مكان اصدار السجل" v-model="register.production_place" outlined hide-details disabled></v-text-field>
                            </v-col>
                            <v-col md="3">
                                <!-- Data ------------------------------------------------------------>
                                <v-text-field label="تاريخ اصدار السجل" v-model="register.date" outlined hide-details disabled></v-text-field>
                            </v-col>

                            <v-col md="3">
                                <!-- Data ------------------------------------------------------------>
                                <v-text-field label="تاريخ انتهاء السجل" v-model="register.EndDate" outlined hide-details disabled></v-text-field>
                            </v-col>
                        </v-row>
                    </div>
                    <v-card>
                        <v-alert type="primary" outlined>
                            <v-card-title>
                                {{$t("note")}}
                            </v-card-title>
                            <v-col sm="6" md="6">
                                <v-text-field disabled v-model="Transaction.secretary_notes" outlined :label="$t('secretary_notes')" required />
                            </v-col>
                            <v-col sm="6" md="6">
                                <v-text-field :disabled="jobTitle != 'reviser'" v-model="Transaction.reviser_notes" outlined :label="$t('reviser_notes')" required />
                            </v-col>
                            <v-col sm="6" md="6">
                                <v-text-field :disabled="jobTitle != 'revisingManager'" v-model="Transaction.revisingManager_notes" outlined :label="$t('revisingManager_notes')" required />
                            </v-col>
                            <v-col sm="6" md="6">
                                <v-text-field :disabled="jobTitle != 'auditor'" v-model="Transaction.auditor_notes" outlined :label="$t('auditor_notes')" required />
                            </v-col>
                            <v-col sm="6" md="6">
                                <v-text-field disabled v-model="Transaction.archiveSecretary_notes" outlined :label="$t('archiveSecretary_notes')" required />
                            </v-col>
                            <v-col sm="6" md="6">
                                <v-btn @click="UpdateTransaction" color="primary" dark>
                                    {{$t('save')}}
                                </v-btn>
                            </v-col>
                        </v-alert>
                    </v-card>
                    <!----- Choose revisers Form Content -->
                    <v-row class="row" id="chooseRevisers">
                        <v-col md="6" v-if="Transaction.auditor">
                            <v-text-field label="المدقق المسؤول" v-model="Transaction.auditor.name" outlined hide-details disabled></v-text-field>
                        </v-col>
                        <v-col md="6" v-if="Transaction.reviser" class="col-md-6">
                            <v-text-field label="المراجع المسؤول" v-model="Transaction.reviser.name" outlined hide-details disabled></v-text-field>
                        </v-col>
                    </v-row>
                    <!----- /.Choose revisers Form Content -->
                </div>
            </div>
        </v-card>
    </v-container>
</div>
</template>

<script>
export default {
    name: "TransactionInfo",
    props: {
        Transaction: Object,
        jobTitle: String
    },
    data() {
        return {
            main_datePicker: false,
            finish_reservation: false
        };
    },
    methods: {
        UpdateTransaction() {
            this.LoadingSpinner = true;

            var formData = new FormData();

            formData.append('_method', 'PATCH');
            formData.append('financial_year', this.Transaction.financial_year);
            formData.append('secretary_notes', this.Transaction.secretary_notes);
            formData.append('reviser_notes', this.Transaction.reviser_notes);
            formData.append('revisingManager_notes', this.Transaction.revisingManager_notes);
            formData.append('auditor_notes', this.Transaction.auditor_notes);
            formData.append('archiveSecretary_notes', this.Transaction.archiveSecretary_notes);
            formData.append('start_financial_year', this.Transaction.start_financial_year);
            formData.append('end_financial_year', this.Transaction.end_financial_year);
            formData.append('financial_period', this.Transaction.financial_period);
            formData.append('MainTradeRegisterNumber', this.Transaction.MainTradeRegisterNumber);
            formData.append('reviser_id', (this.ChoosenReviser.hasOwnProperty('id') ? this.ChoosenReviser.id : this.ChoosenReviser));
            formData.append('revisingManager_id', (this.ChoosenRevisingManager.hasOwnProperty('id') ? this.ChoosenRevisingManager.id : this.ChoosenRevisingManager));
            axios.post(route('Transactions.update', this.Transaction.id), formData)
                .then((res) => {
                    this.LoadingSpinner = false;
                    this.ValidationErrors = '';
                    this.$toast.success('.',
                        'قد تم تعديل بيانات المعاملة بنجاح', {
                            timout: 2000
                        })

                }).catch((error) => {
                    this.LoadingSpinner = false;
                    this.ValidationErrors = error.response.data.errors;
                    this.$toast.error('خطأ', 'يرجى اعادة مراجعة البيانات', {
                        timout: 2000
                    });

                });

        },

    },
};
</script>

<style scoped></style>
