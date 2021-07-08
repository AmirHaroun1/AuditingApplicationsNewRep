<template>
    <div>
        <v-container>
            <v-card style="padding-top: 25px">
                <v-card-title class="mb-3">
                    <span class="mr-3 ml-3">{{
                        $t("auditortransactionsTable")
                    }}</span>
                    <v-spacer></v-spacer>
                    <v-text-field
                        id="search-box"
                        placeholder="ابحث برقم السجل الرئيسي"
                        v-model="search"
                        class="col-md-2 mr-2 ml-2 mt-4"
                        :label="$t('search')"
                        dense
                        small
                        justify="center"
                        single-line
                        solo
                        align-center
                        hide-details
                        @input="searchTransaction"
                        append-icon="mdi-magnify"
                    />
                    <v-spacer></v-spacer>
                    <v-autocomplete
                        :label="$t('filter')"
                        hide-details
                        dense
                        chips
                        multiple
                        return-object
                        v-model="headers"
                        outlined
                        class="col-md-3 mt-4 mr-2"
                        :items="predefinedFilters"
                        small
                        justify="center"
                    >
                        <template v-slot:selection="{ item, index }">
                            <v-chip small v-if="index === 0">
                                <span>{{ item.text }}</span>
                            </v-chip>
                            <span v-if="index === 1" class="grey--text caption">
                                (+{{ headers.length - 1 }} {{ $t("others") }})
                            </span>
                        </template>
                    </v-autocomplete>
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="Transactions"
                    :loading="LoadingSpinner"
                    :options.sync="options"
                    loading-text="Loading... Please wait"
                >
                    <template v-slot:item.MainTradeRegisterNumber="{ item }">
                        <a
                            :href="
                                route(
                                    'transactions.edit.auditor',
                                    item.id
                                )
                            "
                        >
                            {{ item.MainTradeRegisterNumber }}
                        </a>
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
            </v-card>
        </v-container>
    </div>
</template>

<script>
export default {
    name: "AuditorTransactionsTable",
    data() {
        return {
            LoadingSpinner: false,
            Transactions: [],
            SearchedTransactions: [],
            SearchMainRegisterNumber: "",
            OrderByCase: "latest",
            options: {},
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
                    order: this.$t("financialHijriYear"),
                    value: "latest"
                },
                {
                    order: this.$t("financialHijriYear"),
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
