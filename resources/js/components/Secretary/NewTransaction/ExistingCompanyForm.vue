<template>
<div>
    <v-form v-model="valid" @submit.prevent="createTransaction()">
        <v-card>
            <v-card-title>
                {{$t('transactionInfo')}}
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field disabled v-model="MainTradeRegister.number" outlined :rules="numbersRules" autocomplete="MainTradeRegister" :label="$t('mainTradeNumber')" required />
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field disabled v-model="MainTradeRegister.production_place" outlined :rules="required" :label="$t('mainTradePlace')" required />
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                            <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs2 }">
                                    <v-text-field disabled outlined v-model="MainTradeRegister.date" name="national_id_date" :label="$t('mainTradeDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker disabled v-model="MainTradeRegister.date" @input="menu2 = false"></v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                            <v-menu v-model="menu6" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs2 }">
                                    <v-text-field disabled outlined v-model="MainTradeRegister.EndDate" name="national_id_date" :label="$t('mainTradeEndDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker disabled v-model="MainTradeRegister.EndDate" @input="menu6 = false"></v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-card>
                                <v-alert type="primary" outlined>
                                    <v-card-title>
                                        {{$t('companyInfo')}}
                                    </v-card-title>
                                    <v-form id="UpdateInstitutionForm" @submit.prevent="UpdateInstitution()">
                                        <v-row>
                                            <v-col cols="12" sm="6" md="2">
                                                <v-autocomplete v-model="institution.type" :rules="required" outlined :items="InstitutionTypes" :label="$t('InstitutionType')" required />
                                            </v-col>
                                            <v-col cols="12" v-if="institution.type !='charity'" sm="6" md="3">
                                                <v-text-field v-model="institution.number700" outlined autocomplete="number 700" :label="$t('number700')" required />

                                            </v-col>
                                            <v-col cols="12" sm="6" md="2">
                                                <v-text-field v-if="institution.type !='charity'" v-model="institution.number300" outlined autocomplete="number 300" :label="$t('number300')" required />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="2">
                                                <v-text-field v-model="institution.extra_tax_num" outlined :rules="numbersRules" :label="$t('extraTaxesNumber')" required />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="2">
                                                <v-autocomplete v-model="institution.company_nationality" outlined :rules="required" :items="['سعوديه', 'أجنبيه', 'مختلطه']" autocomplete="company_nationality" :label="$t('company_nationality')" required></v-autocomplete>
                                                </v-col>
                                            <div v-if="institution.type=='organization'" class="row" id="NewOrganizationInformation">
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="institution.name" :rules="required" outlined autocomplete="organizationName" :label="$t('organizationName')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="institution.city" outlined :rules="required" :items="cityOptions" item-text="value" item-value="value" :label="$t('addressCity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="institution.restofadress" outlined :rules="required" :label="$t('addressComplete')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.postal_box" outlined :rules="required" :label="$t('postal_box')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.postal_code" outlined :rules="required" :label="$t('postal_code')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.phone" outlined :rules="numbersRules" autocomplete="phone" :label="$t('phone')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.fax" outlined :rules="required" autocomplete="fax" :label="$t('fax')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.merchant_name" outlined :rules="required" autocomplete="merchant_name" :label="$t('merchant_name')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.merchant_nationality" outlined :rules="required" autocomplete="merchant_nationality" :label="$t('merchant_nationality')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-menu v-model="menu3" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                        <template v-slot:activator="{ on, attrs2 }">
                                                            <v-text-field outlined v-model="institution.merchant_birth_date" name="national_id_date" :label="$t('merchant_birth_date')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="institution.merchant_birth_date" @input="menu3 = false"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.capital" outlined :rules="numbersRules" autocomplete="capital" :label="$t('capital')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="ManagerTemp.name" outlined :rules="required" autocomplete="managerName" :label="$t('ManagerTempName')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.manager_authorities" outlined :rules="required" autocomplete="manager_authorities" :label="$t('manager_authorities')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-textarea v-model="institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
                                                </v-col>
                                            </div>
                                            <div v-if="institution.type=='charity'" class="row">
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="institution.name" :rules="required" outlined autocomplete="organizationName" :label="$t('organizationName')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-autocomplete v-model="institution.city" outlined :rules="required" :items="cityOptions" item-text="value" item-value="value" :label="$t('addressCity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="institution.restofadress" outlined :rules="required" :label="$t('addressComplete')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.postal_box" outlined :rules="required" :label="$t('postal_box')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.postal_code" outlined :rules="required" :label="$t('postal_code')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="institution.phone" outlined :rules="numbersRules" autocomplete="phone" :label="$t('phone')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="institution.fax" outlined :rules="required" autocomplete="fax" :label="$t('fax')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-textarea v-model="institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="institution.capital" outlined :rules="required" autocomplete="capital" :label="$t('capital')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="ManagerTemp.name" outlined :rules="required" autocomplete="managerName" :label="$t('ManagerTempName')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="institution.manager_authorities" outlined :rules="required" autocomplete="manager_authorities" :label="$t('manager_authorities')" required />
                                                </v-col>
                                            </div>
                                            <div v-if="institution.type == 'company' " class="row" id="NewCompanyInformation">
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="institution.name" :rules="required" outlined autocomplete="organizationName" :label="$t('companyName')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="institution.legal_entity" :rules="required" outlined item-text="name" item-value="value" :items="legal_entityOptions" :label="$t('legal_entity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                <v-autocomplete v-model="institution.company_nationality" outlined :rules="required" :items="['سعوديه', 'أجنبيه', 'مختلطه']" autocomplete="company_nationality" :label="$t('company_nationality')" required></v-autocomplete>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.company_period" :rules="required" outlined autocomplete="company_period" :label="$t('company_period')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-menu v-model="menu4" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                        <template v-slot:activator="{ on, attrs2 }">
                                                            <v-text-field outlined v-model="institution.company_start_period" name="company_start_period" :label="$t('company_start_period')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="institution.company_start_period" @input="menu4 = false"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-menu v-model="menu5" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                        <template v-slot:activator="{ on, attrs2 }">
                                                            <v-text-field outlined v-model="institution.company_end_period" name="company_end_period" :label="$t('company_end_period')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="institution.company_end_period" @input="menu5 = false"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="institution.city" outlined :rules="required" :items="cityOptions" item-text="value" item-value="value" :label="$t('addressCity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="institution.restofadress" outlined :rules="required" :label="$t('addressComplete')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.postal_box" outlined :rules="required" :label="$t('postal_box')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.postal_code" outlined :rules="required" :label="$t('postal_code')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.phone" outlined :rules="numbersRules" autocomplete="phone" :label="$t('phone')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.fax" outlined :rules="required" autocomplete="fax" :label="$t('fax')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="institution.capital" outlined :rules="required" autocomplete="capital" :label="$t('capital')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-textarea v-model="institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-text-field v-model="ManagerTemp.name" outlined :rules="required" autocomplete="managerName" :label="$t('ManagerTempName')" required />
                                                    <v-btn @click="AddManagerToList()" dark color="success">
                                                        {{$t('addManager')}}
                                                    </v-btn>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-list v-if="institution.managers.length" two-line>
                                                        <v-alert type="primary" outlined>
                                                            <v-subheader inset>{{$t('managers')}}</v-subheader>

                                                            <v-list-item v-for="(manager,index) in institution.managers" :key="manager">
                                                                <v-list-item-avatar>
                                                                    <v-icon class="grey lighten-1" dark>
                                                                        mdi-account
                                                                    </v-icon>
                                                                </v-list-item-avatar>

                                                                <v-list-item-content>
                                                                    <v-list-item-title v-text="manager"></v-list-item-title>
                                                                </v-list-item-content>

                                                                <v-list-item-action>
                                                                    <v-btn @click="RemoveManagerFromList(index)" icon>
                                                                        <v-icon color="grey lighten-1">mdi-delete</v-icon>
                                                                    </v-btn>
                                                                </v-list-item-action>
                                                            </v-list-item>

                                                        </v-alert>
                                                    </v-list>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-text-field v-model="institution.manager_authorities" outlined :rules="required" autocomplete="manager_authorities" :label="$t('manager_authorities')" required />
                                                </v-col>
                                            </div>
                                            <div v-if="institution.type == 'project' " class="row" id="NewProjectInformation">
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-textarea v-model="institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
                                                </v-col>
                                            </div>
                                        </v-row>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn outlined type="submit" form="UpdateInstitutionForm" color="primary" dark>
                                                {{$t('save')}}
                                            </v-btn>
                                            <v-spacer></v-spacer>
                                        </v-card-actions>
                                    </v-form>
                                </v-alert>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-card>
                                <v-alert type="primary" outlined>
                                    <v-card-title>
                                        {{$t('finaincialYear')}}
                                    </v-card-title>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-text-field @change="SetFinancialDates()" v-model="transaction.financial_year" outlined :rules="numbersRules" :label="$t('finaincialYear')" required />
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-autocomplete @change="SetFinancialDates()" v-model="transaction.financial_period" outlined :rules="required" :items="[$t('finaincialYear2'), $t('shortPeriod'), $t('longPeriod')]" item-text="value" item-value="value" :label="$t('finaincialPeriod')" required />
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                            <template v-slot:activator="{ on, attrs2 }">
                                                <v-text-field outlined v-model="transaction.start_financial_year" :label="$t('finaincialYearStart')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                            </template>
                                            <v-date-picker v-model="transaction.start_financial_year"></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                            <template v-slot:activator="{ on, attrs2 }">
                                                <v-text-field outlined v-model="transaction.end_financial_year" :label="$t('finaincialYearEnd')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                            </template>
                                            <v-date-picker v-model="transaction.end_financial_year"></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                </v-alert>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <new-agent-form></new-agent-form>
                        </v-col>

                        <v-col cols="12" sm="12" md="12">
                            <v-card>
                                <v-alert type="primary" outlined>
                                    <v-card-title>
                                        {{$t("note")}}
                                    </v-card-title>
                                    <v-col sm="6" md="6">
                                        <v-text-field v-model="transaction.secretary_notes" outlined :label="$t('secretary_notes')" required />
                                    </v-col>
                                    <v-col sm="6" md="6">
                                        <v-text-field disabled v-model="transaction.reviser_notes" outlined :label="$t('reviser_notes')" required />
                                    </v-col>
                                    <v-col sm="6" md="6">
                                        <v-text-field disabled v-model="transaction.revisingManager_notes" outlined :label="$t('revisingManager_notes')" required />
                                    </v-col>
                                    <v-col sm="6" md="6">
                                        <v-text-field disabled v-model="transaction.auditor_notes" outlined :label="$t('auditor_notes')" required />
                                    </v-col>
                                    <v-col sm="6" md="6">
                                        <v-text-field disabled v-model="transaction.archiveSecretary_notes" outlined :label="$t('archiveSecretary_notes')" required />
                                    </v-col>
                                </v-alert>
                            </v-card>
                        </v-col>
                        <v-col cols="12">
                            <v-card>
                                <v-alert type="primary" outlined>
                                    <v-card-title>
                                        <span class="mr-3 ml-3">{{$t('branchesTrades')}}</span>
                                        <v-spacer></v-spacer>
                                        <v-dialog v-model="addDialog" max-width="600px">
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn color="primary" class="mt-4" dark v-bind="attrs" v-on="on">
                                                    <v-icon>mdi-plus</v-icon> {{$t('addBranchTrade')}}
                                                </v-btn>
                                            </template>
                                            <v-card>
                                                <v-card-title>
                                                    {{$t('addBranchTrade')}}
                                                </v-card-title>
                                                <v-form id="BranchRegisterForm" @submit.prevent="AddBranchedRegister(); addDialog = false">
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-text-field v-model="NewBranchedRegister.number" outlined :rules="numbersRules" :label="$t('tradeNumber')" required />
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-text-field v-model="NewBranchedRegister.production_place" outlined :rules="required" :label="$t('tradePlace')" required />
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                            <template v-slot:activator="{ on, attrs2 }">
                                                                <v-text-field outlined v-model="NewBranchedRegister.date" :label="$t('tradeDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                            </template>
                                                            <v-date-picker v-model="NewBranchedRegister.date"></v-date-picker>
                                                        </v-menu>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                            <template v-slot:activator="{ on, attrs2 }">
                                                                <v-text-field outlined v-model="NewBranchedRegister.EndDate" :label="$t('tradeEndDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                            </template>
                                                            <v-date-picker v-model="NewBranchedRegister.EndDate"></v-date-picker>
                                                        </v-menu>
                                                    </v-col>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn  @click="AddBranchedRegister()" color="primary" dark>
                                                            {{$t('save')}}
                                                        </v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-form>
                                            </v-card>
                                        </v-dialog>
                                    </v-card-title>

                                    <v-data-table :headers="headers" :items="BranchedRegisters">
                                        <template v-slot:item.action="{ item }">
                                            <v-dialog v-model="editDialog" max-width="600px">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-icon small class="mr-2" @click="editDialog = true;" v-on="on" v-bind="attrs">
                                                        mdi-pencil
                                                    </v-icon>
                                                </template>
                                                <v-card>
                                                    <v-card-title>
                                                        {{$t('editBranchTrade')}}
                                                    </v-card-title>
                                                    <v-form id="BranchRegisterFormEdit" @submit.prevent="UpdateRegister(item); editDialog = false;">
                                                        <v-col cols="12" sm="6" md="6">
                                                            <v-text-field v-model="item.number" outlined :rules="numbersRules" :label="$t('tradeNumber')" required />
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="6">
                                                            <v-text-field v-model="item.production_place" outlined :rules="required" :label="$t('tradePlace')" required />
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="6">
                                                            <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                                <template v-slot:activator="{ on, attrs2 }">
                                                                    <v-text-field outlined v-model="item.date" :label="$t('tradeDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="item.date"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="6">
                                                            <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                                <template v-slot:activator="{ on, attrs2 }">
                                                                    <v-text-field outlined v-model="item.EndDate" :label="$t('tradeEndDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="item.EndDate"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn type="submit" form="BranchRegisterFormEdit" color="primary" dark>
                                                                {{$t('save')}}
                                                            </v-btn>
                                                            <v-spacer></v-spacer>
                                                        </v-card-actions>
                                                    </v-form>
                                                </v-card>
                                            </v-dialog>
                                            <v-icon small @click="DeleteRegister(item)">
                                                mdi-delete
                                            </v-icon>
                                        </template>
                                    </v-data-table>
                                </v-alert>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                            <v-autocomplete v-model="ChoosenReviserID" outlined :rules="required" :items="revisers" item-text="name" item-value="id" :label="$t('reviser')" required />
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                            <v-autocomplete v-model="ChoosenRevisingManagerID" outlined :rules="required" :items="revisingManagers" item-text="name" item-value="id" :label="$t('revisingManager')" required />
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn type="submit" color="primary" dark>
                    {{$t('save')}}
                </v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-form>
</div>
</template>

<script>
export default {
    name: "ExistingCompanyForm",
    data() {
        return {
            LoadingSpinner: '',
            ValidationErrors: '',
            InstitutionTypes: [{
                    text: this.$t('organization'),
                    value: 'organization'
                },
                {
                    text: this.$t('company'),
                    value: 'company'
                },
                {
                    text: this.$t('project'),
                    value: 'project'
                },
                {
                    text: this.$t('charity'),
                    value: 'charity'
                },
                {
                    text: this.$t('other'),
                    value: 'other'
                },

            ],
            headers: [{
                    text: this.$t('tradeNumber'),
                    align: 'start',
                    value: 'number',
                },
                {
                    text: this.$t('tradePlace'),
                    value: 'production_place',
                },
                {
                    text: this.$t('tradeDate'),
                    value: 'date',
                },
                {
                    text: this.$t('tradeEndDate'),
                    value: 'EndDate',
                },
                {
                    text: this.$t('action'),
                    value: 'action',
                },
            ],
            institution: this.$parent.$parent.$parent.Institution,
            MainTradeRegister: this.$parent.$parent.$parent.TradeRegister,
            BranchedRegisters: [],

            ManagerTemp: {
                'name': '',
            },
            /////  create Transaction Data ///////////
            transaction: {
                financial_year: '',
                start_financial_year: '',
                end_financial_year: '',
                financial_period: '',
            },
            /////// Added Branched Register //////////
            NewBranchedRegister: {
                id: '',
                number: '',
                date: '',
                EndDate: '',
                production_place: '',
                type: 'فرعي'
            },

            City: '',

            RestOfAddress: '',
            CompanyError: false,

            legal_entityOptions: [],
            angel_interestsOptions: [],
            natureOptions: [],
            cityOptions: [],


            revisers: [],
            revisingManagers: [],

            ChoosenReviserID: '',
            ChoosenRevisingManagerID: '',

            numbersRules: [
                v => !!v || this.$t('requiredField'),
                v => /^\d+$/.test(v) || this.$t('numbersOnly'),
            ],
            emailRules: [
                v => !!v || this.$t('requiredField'),
                v => /.+@.+/.test(v) || this.$t('emailNotValid'),
            ],
            required: [
                v => !!v || this.$t('requiredField'),
            ],

        }
    },
    created() {
        this.GetRevisers(route('employee.type', 'مراجع فني'));
        this.GetRevisingManagers(route('employee.type', 'مدير مراجعة'));;
        this.GetDropDowns(route('system.DropDowns.retrieve.option'));

        this.BranchedRegisters = this.$parent.$parent.$parent.Institution.branched_trade_register;
        this.City = this.institution.address.split(',')[0];
        this.RestOfAddress = this.institution.address.split(',')[1];
    },
    methods: {
        // get all the revisers in the system and put them in the array
        GetRevisers(endpoint) {
            axios.get(endpoint)
                .then(({
                    data
                }) => {
                    data.employees.forEach((reviser) => {
                        this.revisers.push(reviser);
                    });
                })
        },
        // get all the RevisingManagers in the system and put them in the array
        GetRevisingManagers(endpoint) {
            axios.get(endpoint)
                .then(({
                    data
                }) => {
                    data.employees.forEach((revisingManager) => {
                        this.revisingManagers.push(revisingManager);
                    });
                })
        },
        // get DropDowns
        GetDropDowns(endpoint) {
            axios.get(endpoint)
                .then(({
                    data
                }) => {
                    data.DropDownsOptions.forEach((option, index) => {

                        if (option.name == 'الكيان القانونى') {
                            this.legal_entityOptions.push(option);
                        } else if (option.name == 'اهتمامات الملاك') {
                            this.angel_interestsOptions.push(option);
                        } else if (option.name == 'طبيعة ملكية المنشأة وكيفية تمويلها') {
                            this.natureOptions.push(option);
                        } else if (option.name == 'المدينة') {
                            this.cityOptions.push(option);
                        }

                    })
                })
        },
        UpdateRegister(register) {
            this.LoadingSpinner = true;
            let formData = new FormData();

            formData.append('_method', 'PATCH');
            formData.append('register_ID', register.id);
            formData.append('number', register.number);
            formData.append('date', register.date);
            formData.append('EndDate', register.EndDate);
            formData.append('production_place', register.production_place);
            formData.append('type', register.type);

            axios.post(route('TradeRegister.update', register.id), formData)
                .then(({
                    data
                }) => {
                    this.LoadingSpinner = false;
                    this.$toast.success('.',
                        'قد تم تعديل  بيانات السجل بنجاح ', {
                            timout: 2000
                        });
                    this.ValidationErrors = '';
                })
                .catch((error) => {
                    this.LoadingSpinner = false;
                    this.ValidationErrors = error.response.data.errors;
                    this.$toast.error('خطأ', register.number + 'يرجى اعادة مراجعة بيانات سجل فرعي رقم ', {
                        timout: 2000
                    });
                })
        },
        DeleteRegister(register) {
            this.LoadingSpinner = true;

            let formDate = new FormData();

            formDate.append('_method', 'DELETE');

            axios.post(route('TradeRegister.delete', register.id), formDate)
                .then(res => {
                    this.LoadingSpinner = false;

                    this.$toast.success('.',
                        'قد تم حذف  بيانات السجل بنجاح ', {
                            timout: 2000
                        });
                    this.BranchedRegisters.splice(this.BranchedRegisters.indexOf(register), 1);
                    this.ValidationErrors = '';

                })
                .catch(error => {
                    this.LoadingSpinner = false;

                    this.ValidationErrors = error.response.data.errors;
                    this.$toast.error('خطأ', 'خطأ اثناء الحذف حاول مرة أخرى ', {
                        timout: 2000
                    });
                })
        },
        AddBranchedRegister() {
            console.log('brances');
            this.LoadingSpinner = true;

            let formData = new FormData();

            formData.append('number', this.NewBranchedRegister.number);
            formData.append('date', this.NewBranchedRegister.date);
            formData.append('EndDate', this.NewBranchedRegister.EndDate);
            formData.append('production_place', this.NewBranchedRegister.production_place);
            formData.append('type', this.NewBranchedRegister.type);

            axios.post(route('TradeRegister.store', this.$parent.$parent.$parent.Institution), formData)
                .then(({
                    data
                }) => {
                    this.LoadingSpinner = false;

                    this.$toast.success('.',
                        'قد تم اضافة السجل بنجاح ', {
                            timout: 2000
                        });
                    this.ValidationErrors = '';
                    this.BranchedRegisters.push({
                        'id': data.id,
                        'number': data.number,
                        'date': data.date,
                        'EndDate': data.EndDate,
                        'production_place': data.production_place,
                    })
                    this.clearNewBranchInput();
                })
                .catch((error) => {
                    this.LoadingSpinner = false;

                    this.ValidationErrors = error.response.data.errors;
                    this.$toast.error('خطأ', register.number + 'يرجى اعادة مراجعة بيانات سجل فرعي رقم ', {
                        timout: 2000
                    });
                })

        },
        clearNewBranchInput() {
            this.NewBranchedRegister.number = '';
            this.NewBranchedRegister.date = '';
            this.NewBranchedRegister.production_place = '';
        },
        UpdateInstitution() {
            this.LoadingSpinner = true;

            var formData = new FormData();

            formData.append('_method', 'PATCH');
            formData.append('address', this.getAddress);
            formData.append('business_activity', this.institution.business_activity);
            formData.append('name', this.institution.name);
            formData.append('number', this.institution.number);
            formData.append('legal_entity', this.institution.legal_entity);
            formData.append('angel_interests', this.institution.angel_interests);
            formData.append('date_type', this.institution.date_type);
            formData.append('nature', this.institution.nature);
            formData.append('charity_num', this.institution.charity_num);
            formData.append('extra_tax_num', this.institution.extra_tax_num);
            axios.post(route('Institution.update', this.institution.id),
                formData
            ).then((res) => {
                this.LoadingSpinner = false;

                this.$toast.success('.',
                    'قد تم تعديل بيانات المنشأة بنجاح ', {
                        timout: 2000
                    });
                this.CompanyError = false;

            }).catch((error) => {
                this.LoadingSpinner = false;

                this.ValidationErrors = error.response.data.errors;
                this.CompanyError = true;
                this.$toast.error('خطأ', 'يرجى اعادة مراجعة البيانات', {
                    timout: 2000
                });

            });
        },

        createTransaction() {
            this.LoadingSpinner = true;

            var formData = new FormData();

            formData.append('financial_year', this.transaction.financial_year);
            formData.append('start_financial_year', this.transaction.start_financial_year);
            formData.append('end_financial_year', this.transaction.end_financial_year);

            formData.append('secretary_notes', this.transaction.secretary_notes);
            formData.append('reviser_notes', this.transaction.reviser_notes);
            formData.append('revisingManager_notes', this.transaction.revisingManager_notes);
            formData.append('auditor_notes', this.transaction.auditor_notes);
            formData.append('archiveSecretary_notes', this.transaction.archiveSecretary_notes);

            formData.append('financial_period', this.transaction.financial_period);

            formData.append('MainTradeRegisterNumber', this.MainTradeRegister.number);
            formData.append('revisingManager_id', this.ChoosenRevisingManagerID);

            formData.append('institution_id', this.institution.id);
            formData.append('reviser_id', this.ChoosenReviserID);

            axios.post(route('Transactions.store'), formData)
                .then(({
                    data
                }) => {
                    this.LoadingSpinner = false;

                    this.$toast.success('.',
                        'قد تم انشاء معاملة جديدة بنجاح ', {
                            timout: 2000
                        })
                    this.$parent.$parent.$parent.Transaction = data[0];
                    this.$parent.$parent.$parent.SectionStage = 2;
                }).catch((error) => {
                    this.LoadingSpinner = false;
                    this.ValidationErrors = error.response.data.errors;
                    this.$toast.error('خطأ', 'يرجى اعادة مراجعة البيانات', {
                        timout: 2000
                    });

                });
        },

        SetFinancialDates() {
            if (this.transaction.financial_period == 'سنة مالية') {
                this.transaction.start_financial_year = this.transaction.financial_year + "-01-01";
                this.transaction.end_financial_year = this.transaction.financial_year + "-12-31";
            }
        },

        AddManagerToList() {
            let name = this.ManagerTemp.name;
            this.institution.managers.push(name);
            this.ManagerTemp.name = '';
        },
    },
    computed: {
        getAddress() {
            return this.City + ',' + this.RestOfAddress;
        }
    }
}
</script>

<style scoped>

</style>
