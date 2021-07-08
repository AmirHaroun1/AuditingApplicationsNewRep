<template>
    <v-card class="pt-5">
        <v-card-title>
            <span class="mr-3 ml-3">جمع المعاملات المسجلة</span>
            <v-spacer></v-spacer>
        </v-card-title>

        <v-card-text class="px-5 table-responsive no-padding">
            <v-row class="justify-end my-4">
                <v-col md="3" cols="6" >
                    <v-text-field
                        id="search-box"
                        placeholder="ابحث برقم السجل الرئيسي"
                        v-model="search"
                        :label="$t('search')"
                        dense
                        small
                        justify="center"
                        single-line
                        solo
                        align-center
                        hide-details
                        @click:append="searchTransaction"
                         @change="searchTransaction"
                        style="width:100%"
                        append-icon="mdi-magnify"
                    />
                </v-col>
                <v-col md="2" cols="4">
                    <v-select
                        style="width:100%"
                        v-model="OrderByCase"
                        @input="
                            [
                                SearchedTransactions.length
                                    ? search()
                                    : fetchTransactions()
                            ]
                        "
                        name="orderpartnerselecct"
                        :options="orders"
                        :clearable="false"
                        :reduce="option => option.value"
                        label="order"
                    >
                    </v-select>
                </v-col>
            </v-row>
            <v-data-table
                class="table-border"
                :headers="headers"
                :items="Transactions"
                :loading="LoadingSpinner"
                loading-text="Loading... Please wait"
                :options.sync="options"
            >
                <template v-slot:item.MainTradeRegisterNumber="{ item }">
                    <a :href="route('transactions.edit.partner', item.id)">
                        {{ item.MainTradeRegisterNumber }}
                    </a>
                </template>
                <template v-slot:item.status="{ item }">
                    <p class="red--text text--darken-1">
                        {{ item.status }}
                    </p>
                </template>
                <template :ref="item.id" v-slot:item.action="{ item }">
                    <v-icon small color="primary" @click="editItem(item.id)">
                        mdi-pencil
                    </v-icon>
                    <v-icon small color="error" @click="deleteItem(item.id)">
                        mdi-delete
                    </v-icon>
                    <v-icon small color="grey" @click="printRow(item.id)">
                        mdi-printer
                    </v-icon>
                </template>
            </v-data-table>

            <!-- <table class="table table-hover">
                <tbody><tr>
                    <th>رقم السجل الرئيسي</th>
                    <th>تاريخ تسجيل المعاملة (ميلادي)</th>
                    <th>تاريخ تسجيل المعاملة (هجري)</th>
                    <th>الحالة</th>
                    <th>السنة المالية (ميلادي)</th>
                    <th>السنة المالية (هجري)</th>
                </tr>
                <tr v-if="SearchedTransactions.length" v-for="transaction in SearchedTransactions">
                    <td><a :href="route('transactions.edit.partner',transaction.id)"> {{transaction.MainTradeRegisterNumber}}</a></td>
                    <td>{{transaction.created_at}}</td>
                    <td>{{transaction.hijri_created_at}}</td>
                    <td><h4  style="color: red">{{transaction.status}}</h4></td>
                    <td>{{transaction.financial_year}}</td>
                    <td>{{transaction.hijri_financial_year}}</td>
                </tr>
                <tr v-if="!SearchedTransactions.length" v-for="transaction in Transactions">

                    <td><a :href="route('transactions.edit.partner',transaction.id)"> {{transaction.MainTradeRegisterNumber}}</a></td>
                    <td>{{transaction.created_at}}</td>
                    <td>{{transaction.hijri_created_at}}</td>
                    <td><h4  style="color: red">{{transaction.status}}</h4></td>
                    <td>{{transaction.financial_year}}</td>
                    <td>{{transaction.hijri_financial_year}}</td>
                </tr>

                <div v-if="LoadingSpinner" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                </tbody>
            </table> -->

            <!-- <div v-if="!SearchedTransactions.length" class="pagination text-center">
                <button class="btn btn-default" @click="fetchTransactions(FetchPaginationData.current_page-1)" :disabled="!FetchPaginationData.prev_page_url">السابق</button>
                <span>صفحة
                    {{FetchPaginationData.current_page}}
                    من
                    {{FetchPaginationData.last_page}}
                </span>
                <button class="btn btn-default" @click="fetchTransactions(FetchPaginationData.current_page+1)" :disabled="!FetchPaginationData.next_page_url">التالي</button>

            </div>
            <div v-else-if="SearchedTransactions.length" class="pagination text-center">
                <button class="btn btn-default" @click="search(SearchPaginationData.current_page-1)" :disabled="!SearchPaginationData.prev_page_url">السابق</button>
                <span>صفحة
                    {{SearchPaginationData.current_page}}
                    من
                    {{SearchPaginationData.last_page}}
                </span>
                <button class="btn btn-default" @click="search(SearchPaginationData.current_page+1)" :disabled="!SearchPaginationData.next_page_url">التالي</button>
            </div> -->
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "PartnerTransactionsTable",
    data() {
        return {
            LoadingSpinner: false,
            Transactions: [],
            SearchedTransactions: [],
            SearchMainRegisterNumber: "",
            OrderByCase: "latest",

            FetchPaginationData: {
                current_page: 0,
                last_page: "",
                next_page_url: "",
                prev_page_url: ""
            },
            SearchPaginationData: {
                current_page: 0,
                last_page: "",
                next_page_url: "",
                prev_page_url: ""
            },
            headers: [{
                    text: this.$t('mainItemNumber'),
                    align: 'start',
                    value: 'MainTradeRegisterNumber',
                },
                {
                    text: this.$t('TransactionChirstianDate'),
                    value: 'created_at'
                },
                {
                    text: this.$t('TransactionHijriDate'),
                    value: 'hijri_created_at'
                },
                {
                    text: this.$t('status'),
                    value: 'status'
                },
                {
                    text: this.$t('financialChristianYear'),
                    value: 'financial_year',
                    width: "10%"    
                },
                {
                    text: this.$t('financialHijriYear'),
                    value: 'hijri_financial_year',
                    width: "10%"
                },
                {
                    text: this.$t('action'),
                    value: 'action'
                },
            ],
            predefinedFilters: [
                {
                    text: this.$t("mainItemNumber"),
                    align: "start",
                    value: "MainTradeRegisterNumber"
                },
                {
                    text: this.$t("TransactionChirstianDate"),
                    value: "created_at"
                },
                {
                    text: this.$t("TransactionHijriDate"),
                    value: "hijri_created_at"
                },
                {
                    text: this.$t("status"),
                    value: "status"
                },
                {
                    text: this.$t("financialChristianYear"),
                    value: "financial_year"
                },
                {
                    text: this.$t("financialHijriYear"),
                    value: "hijri_financial_year"
                }
            ],
            orders: [
                {
                    order: this.$t("latest"),
                    value: "latest"
                },
                {
                    order: this.$t("oldest"),
                    value: "oldest"
                }
            ]
        };
    },
    created() {
        this.fetchTransactions();
    },
    methods: {
        fetchTransactions(page = 1) {
            this.LoadingSpinner = true;
            axios
                .get(
                    route("transactions.index", {
                        OrderByCase: this.OrderByCase,
                        page
                    })
                )
                .then(({ data }) => {
                    this.LoadingSpinner = false;

                    this.FetchPaginationData.current_page =
                        data.transactions.current_page;
                    this.FetchPaginationData.last_page =
                        data.transactions.last_page;
                    this.FetchPaginationData.next_page_url =
                        data.transactions.next_page_url;
                    this.FetchPaginationData.prev_page_url =
                        data.transactions.prev_page_url;

                    this.Transactions = [];
                    this.Transactions.push(...data.transactions.data);
                });
        },
        searchTransaction() {
            this.LoadingSpinner = true;

            axios
                .get(
                    route("transactions.index", {
                    OrderByCase: this.OrderByCase,
                    page: this.options.page,
                    MainRegisterNumber: this.search
                    })
                )
                .then(({ data }) => {
                    this.LoadingSpinner = false;

                    this.SearchPaginationData.current_page =
                        data.transactions.current_page;
                    this.SearchPaginationData.last_page =
                        data.transactions.last_page;
                    this.SearchPaginationData.next_page_url =
                        data.transactions.next_page_url;
                    this.SearchPaginationData.prev_page_url =
                        data.transactions.prev_page_url;

                    this.SearchedTransactions = [];
                    this.SearchedTransactions.push(...data.transactions.data);

                    if (!this.SearchedTransactions.length) {
                        this.$toast.warning(
                            ",",
                            "لا يوجد معاملات تحتوى على رقم السجل",
                            { timout: 2000 }
                        );
                    }
                });
        },
                printRow(item) {
            console.log('item', item);
        },
        editItem(item) {
            window.location.href = route('transactions.edit.reviser', item)
        },
        deleteItem(item) {
            this.LoadingSpinner = true;
            axios.delete(route('transactions.index'))
                .then(({
                    data
                }) => {

                    this.LoadingSpinner = false;

                })

        }
    },
            watch: {
      options: {
        handler () {
          this.searchTransaction()
        },
        deep: true,
      },
    },
};
</script>

<style scoped></style>
