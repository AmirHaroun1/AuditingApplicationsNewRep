<template>
<div>
    <v-form v-model="valid" @submit.prevent="UpdateMainRegister()">
        <v-card>
            <v-card-title>
                {{$t('transactionInfo')}}
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field v-model="MainTradeRegister.number" outlined :rules="numbersRules" autocomplete="MainTradeRegister" :label="$t('mainTradeNumber')" required />
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field v-model="MainTradeRegister.production_place" outlined :rules="required" :label="$t('mainTradePlace')" required />
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                            <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs2 }">
                                    <v-text-field outlined v-model="MainTradeRegister.date" name="national_id_date" :label="$t('mainTradeDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker v-model="MainTradeRegister.date" @input="menu2 = false"></v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                            <v-menu v-model="menu6" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs2 }">
                                    <v-text-field outlined v-model="MainTradeRegister.EndDate" name="national_id_date" :label="$t('mainTradeEndDate')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker v-model="MainTradeRegister.EndDate" @input="menu6 = false"></v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-card>
                                <v-alert type="primary" outlined>
                                    <v-card-title>
                                        {{$t('copmanyInfo')}}
                                    </v-card-title>
                                    <v-form id="UpdateInstitutionForm" @submit.prevent="UpdateInstitution()">
                                        <v-row>
                                            <v-col cols="12" sm="6" md="3">
                                                <v-autocomplete v-model="Institution.type" :rules="required" outlined :items="InstitutionTypes" :label="$t('InstitutionType')" required />
                                            </v-col>
                                            <v-col cols="12" v-if="Institution.type !='chairty'" sm="6" md="3">
                                                <v-text-field v-model="Institution.number700" outlined autocomplete="number 700" :label="$t('number700')" required />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="3">
                                                <v-text-field v-if="Institution.type !='chairty'" v-model="Institution.number300" outlined autocomplete="number 300" :label="$t('number300')" required />
                                            </v-col>
                                            <v-col cols="12" sm="6" md="3">
                                                <v-text-field v-model="Institution.extra_tax_num" outlined :rules="numbersRules" :label="$t('extraTaxesNumber')" required />
                                            </v-col>
                                            <div v-if="Institution.type=='organization'" class="row" id="NewOrganizationInformation">
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="Institution.name" :rules="required" outlined autocomplete="organizationName" :label="$t('organizationName')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="Institution.city" outlined :rules="required" :items="cityOptions" item-text="value" item-value="value" :label="$t('addressCity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="Institution.district" outlined :rules="required" :items="districtOptions" item-text="value" item-value="value" :label="$t('addressDistrict')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="Institution.restofadress" outlined :rules="required" :label="$t('addressComplete')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.postal_box" outlined :rules="required" :label="$t('postal_box')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.postal_code" outlined :rules="required" :label="$t('postal_code')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.phone" outlined :rules="numbersRules" autocomplete="phone" :label="$t('phone')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.fax" outlined :rules="required" autocomplete="fax" :label="$t('fax')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.merchant_name" outlined :rules="required" autocomplete="merchant_name" :label="$t('merchant_name')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.merchant_nationality" outlined :rules="required" autocomplete="merchant_nationality" :label="$t('merchant_nationality')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-menu v-model="menu3" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                        <template v-slot:activator="{ on, attrs2 }">
                                                            <v-text-field outlined v-model="Institution.merchant_birth_date" name="national_id_date" :label="$t('merchant_birth_date')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="Institution.merchant_birth_date" @input="menu3 = false"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.capital" outlined :rules="numbersRules" autocomplete="capital" :label="$t('capital')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="ManagerTemp.name" outlined :rules="required" autocomplete="managerName" :label="$t('ManagerTempName')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.manager_authorities" outlined :rules="required" autocomplete="manager_authorities" :label="$t('manager_authorities')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-textarea v-model="Institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
                                                </v-col>
                                            </div>
                                            <div v-if="Institution.type=='chairty'" class="row">
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="Institution.name" :rules="required" outlined autocomplete="organizationName" :label="$t('organizationName')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-autocomplete v-model="Institution.city" outlined :rules="required" :items="cityOptions" item-text="value" item-value="value" :label="$t('addressCity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-autocomplete v-model="Institution.district" outlined :rules="required" :items="districtOptions" item-text="value" item-value="value" :label="$t('addressDistrict')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="Institution.restofadress" outlined :rules="required" :label="$t('addressComplete')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.postal_box" outlined :rules="required" :label="$t('postal_box')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.postal_code" outlined :rules="required" :label="$t('postal_code')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="Institution.phone" outlined :rules="numbersRules" autocomplete="phone" :label="$t('phone')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="Institution.fax" outlined :rules="required" autocomplete="fax" :label="$t('fax')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-textarea v-model="Institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="Institution.capital" outlined :rules="required" autocomplete="capital" :label="$t('capital')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="ManagerTemp.name" outlined :rules="required" autocomplete="managerName" :label="$t('ManagerTempName')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field v-model="Institution.manager_authorities" outlined :rules="required" autocomplete="manager_authorities" :label="$t('manager_authorities')" required />
                                                </v-col>
                                            </div>
                                            <div v-if="Institution.type == 'company' " class="row" id="NewCompanyInformation">
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="Institution.name" :rules="required" outlined autocomplete="organizationName" :label="$t('companyName')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="Institution.legal_entity" :rules="required" outlined item-text="name" item-value="value" :items="legal_entityOptions" :label="$t('legal_entity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                <v-autocomplete v-model="institution.company_nationality" outlined :rules="required" :items="['سعوديه', 'أجنبيه', 'مختلطه']" autocomplete="company_nationality" :label="$t('company_nationality')" required></v-autocomplete>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.company_period" :rules="required" outlined autocomplete="company_period" :label="$t('company_period')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-menu v-model="menu4" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                        <template v-slot:activator="{ on, attrs2 }">
                                                            <v-text-field outlined v-model="Institution.company_start_period" name="company_start_period" :label="$t('company_start_period')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="Institution.company_start_period" @input="menu4 = false"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-menu v-model="menu5" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                        <template v-slot:activator="{ on, attrs2 }">
                                                            <v-text-field outlined v-model="Institution.company_end_period" name="company_end_period" :label="$t('company_end_period')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="Institution.company_end_period" @input="menu5 = false"></v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="Institution.city" outlined :rules="required" :items="cityOptions" item-text="value" item-value="value" :label="$t('addressCity')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-autocomplete v-model="Institution.district" outlined :rules="required" :items="districtOptions" item-text="value" item-value="value" :label="$t('addressDistrict')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="3">
                                                    <v-text-field v-model="Institution.restofadress" outlined :rules="required" :label="$t('addressComplete')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.postal_box" outlined :rules="required" :label="$t('postal_box')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.postal_code" outlined :rules="required" :label="$t('postal_code')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.phone" outlined :rules="numbersRules" autocomplete="phone" :label="$t('phone')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.fax" outlined :rules="required" autocomplete="fax" :label="$t('fax')" required></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="2">
                                                    <v-text-field v-model="Institution.capital" outlined :rules="required" autocomplete="capital" :label="$t('capital')" required />
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-textarea v-model="Institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
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
                                                    <v-list v-if="Institution.managers.length" two-line>
                                                        <v-alert type="primary" outlined>
                                                            <v-subheader inset>{{$t('managers')}}</v-subheader>

                                                            <v-list-item v-for="(manager,index) in Institution.managers" :key="manager">
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
                                                    <v-text-field v-model="Institution.manager_authorities" outlined :rules="required" autocomplete="manager_authorities" :label="$t('manager_authorities')" required />
                                                </v-col>
                                            </div>
                                            <div v-if="Institution.type == 'project' " class="row" id="NewProjectInformation">
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-textarea v-model="Institution.business_activity" outlined :rules="required" autocomplete="business_activity" :label="$t('business_activity')" required />
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
                        <v-col cols="12" sm="6" md="6">
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-card>
                                <v-alert type="primary" outlined>
                                    <v-card-title>
                                        {{$t('finaincialYear')}}
                                    </v-card-title>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-text-field @change="SetFinancialDates()" v-model="Transaction.financial_year" outlined :rules="numbersRules" :label="$t('finaincialYear')" required />
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-autocomplete @change="SetFinancialDates()" v-model="Transaction.financial_period" outlined :rules="required" :items="[$t('finaincialYear2'), $t('shortPeriod'), $t('longPeriod')]" item-text="value" item-value="value" :label="$t('finaincialPeriod')" required />
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                            <template v-slot:activator="{ on, attrs2 }">
                                                <v-text-field outlined v-model="Transaction.start_financial_year" :label="$t('finaincialYearStart')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                            </template>
                                            <v-date-picker v-model="Transaction.start_financial_year"></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="3">
                                        <v-menu :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                            <template v-slot:activator="{ on, attrs2 }">
                                                <v-text-field outlined v-model="Transaction.end_financial_year" :label="$t('finaincialYearEnd')" append-icon="mdi-calendar" readonly v-bind="attrs2" v-on="on"></v-text-field>
                                            </template>
                                            <v-date-picker v-model="Transaction.end_financial_year"></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                </v-alert>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="12" sm="12" md="12">
                            <div v-if="Agent !== null">
                                <edit-agent-form> </edit-agent-form>
                            </div>
                            <div v-else>
                                <new-agent-form></new-agent-form>
                            </div>
                        </v-col>
                        <v-card>
                            <v-alert type="primary" outlined>
                                <v-card-title>
                                    {{$t("note")}}
                                </v-card-title>
                                <v-col sm="6" md="6">
                                    <v-text-field v-model="Transaction.secretary_notes" outlined :label="$t('secretary_notes')" required />
                                </v-col>
                                <v-col sm="6" md="6">
                                    <v-text-field disabled v-model="Transaction.reviser_notes" outlined :label="$t('reviser_notes')" required />
                                </v-col>
                                <v-col sm="6" md="6">
                                    <v-text-field disabled v-model="Transaction.revisingManager_notes" outlined :label="$t('revisingManager_notes')" required />
                                </v-col>
                                <v-col sm="6" md="6">
                                    <v-text-field disabled v-model="Transaction.auditor_notes" outlined :label="$t('auditor_notes')" required />
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
                                                        <v-btn type="submit" form="BranchRegisterForm" color="primary" dark>
                                                            {{$t('save')}}
                                                        </v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-form>
                                            </v-card>
                                        </v-dialog>
                                    </v-card-title>

                                    <v-data-table :headers="headers" :items="BranchedTradeRegisters">
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
                            <v-autocomplete v-model="ChoosenReviser" outlined :rules="required" :items="revisers" item-text="label" item-value="code" :label="$t('reviser')" required />
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                            <v-autocomplete v-model="ChoosenRevisingManager" outlined :rules="required" :items="revisingManagers" item-text="label" item-value="code" :label="$t('revisingManager')" required />
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
    <div v-if="LoadingSpinner" class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
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
