<template>
<div>
    <!-- Find Trade Register Section -->
    <div v-if="IsNewRegister === null" id="SearchTradeRegister">
        <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="SearchTradeRegister()">
            <v-card>
                <v-card-title>
                    {{$t('transactionInfo')}}
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row justify-center>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-if="!LoadingSpinner" v-model="TradeRegisterInput" outlined :rules="required" :label="$t('enterCopmanyMainNumber')" />
                            </v-col>
                            <v-progress-circular v-if="LoadingSpinner" indeterminate color="primary"></v-progress-circular>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn type="submit" color="success" dark>
                        {{$t('next')}}
                    </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-form>

    </div>
    <!-- /.Find Trade Register Section -->

    <!-- New Company Section -->
    <div v-if="IsNewRegister" id="NewCompany" style="padding-top:20px">
        <v-stepper v-model="SectionStage">
            <v-stepper-header>
                <v-stepper-step :complete="SectionStage > 1" step="1">
                    {{$t('companyData')}}
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="2">
                    {{$t('files')}}
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">
                    {{$t('payment')}}
                </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <new-company-form></new-company-form>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <documents-management-section :transaction="Transaction"></documents-management-section>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <payment-details-form :Transaction="Transaction"></payment-details-form>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </div>

    <!-- /.New Company Section -->

    <!-- /.Existing Company Section -->
    <div v-else-if="IsNewRegister == false" id="ExistingCompany" style="padding-top:20px">
        <v-stepper v-model="SectionStage">
            <v-stepper-header>
                <v-stepper-step :complete="SectionStage > 1" step="1">
                    {{$t('companyData')}}
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">
                    {{$t('files')}}
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="4">
                    {{$t('payment')}}
                </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <existing-company-form></existing-company-form>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <documents-management-section :transaction="Transaction"></documents-management-section>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <payment-details-form :Transaction="Transaction"></payment-details-form>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </div>
    <!-- /.Existing Company Section -->

</div>
</template>

<script>
export default {
    data() {
        return {
            LoadingSpinner: false,
            ValidationErrors: '',
            valid: true,
            IsNewRegister: null,
            TradeRegisterInput: '',

            TradeRegister: '',

            SectionStage: 2,

            Institution: '',
            Agent: '',
            Transaction: '',

            required: [
                v => !!v || this.$t('requiredField'),
                v => (v && v.length == 10) || this.$t('requiredField'),
            ],

            NonActiveCircle: {
                'numberCircle': true,
            },
            ActiveCircle: {
                'activeNumberCircle': true,
            },
            ActiveHeading: {
                'activeNumberHeading': true,
            },

        }
    },
    name: "NewTransaction.vue",
    methods: {
        SearchTradeRegister() {
            this.$refs.form.validate()
            this.IsNewRegister = null;
            this.LoadingSpinner = true;
            let formData = new FormData();
            formData.append('RegisterNumber', this.TradeRegisterInput);
            axios.post(route('TradeRegister.search'), formData)
                .then(({
                    data
                }) => {

                    if (data.TradeRegister[0]) {
                        this.LoadingSpinner = false;

                        this.TradeRegister = '';

                        this.SectionStage = 1;

                        this.Institution = '';
                        this.Agent = '';
                        this.Transaction = '';

                        this.TradeRegister = data.TradeRegister[0];
                        this.Institution = data.TradeRegister[0].institution;
                        this.Agent = data.TradeRegister[0].institution.agent;
                        this.IsNewRegister = false;

                        this.$toast.success('<i class="fa fa-building"></i>', 'بدء معاملة لصالح منشأة مسجلة', {
                            timout: 3000
                        });
                        this.ValidationErrors = '';

                    } else {
                        this.LoadingSpinner = false;

                        this.TradeRegister = '';

                        this.SectionStage = 1;

                        this.Institution = '';
                        this.Agent = '';
                        this.Transaction = '';

                        this.$toast.success('<i class="fa fa-building"></i>', 'بدء معاملة لصالح منشأة جديدة', {
                            timout: 3000
                        });
                        this.IsNewRegister = true;
                        this.ValidationErrors = '';

                    }
                })
                .catch((error) => {
                    //this.$toast.error(error.response.data.errors.RegisterNumber,'خطأ',{timout:3000});
                    this.ValidationErrors = error.response.data.errors;
                })
        }
    },
    computed: {

    },
}
</script>

<style scoped>

</style>
