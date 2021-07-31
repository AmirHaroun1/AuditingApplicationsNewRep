<template>
<div id="DocumentsUploadSection">
    <v-data-table dense :headers="headers" :items="RequiredDocuments" :expanded.sync="expanded" show-expand>
        <template style="box-shadow:none;" v-slot:expanded-item="{ headers, item }">
            <td style="box-shadow:none;" :colspan="headers.length">
                <v-simple-table dense>
                    <tbody>
                        <tr v-for="(file) in item.transactions" :key="file.pivot.DocumentPath">
                            <td>{{file.pivot.original_name}}</td>
                            <td>
                                <a :href="DownloadDocumentLink(file.pivot.DocumentPath,file.pivot.original_name)">
                                    <v-icon small class="mr-2">
                                        mdi-download
                                    </v-icon>
                                </a>
                                <v-icon @click="DeleteDocuments(item,file)" small>
                                    mdi-delete
                                </v-icon>
                            </td>
                        </tr>
                    </tbody>
                </v-simple-table>
            </td>
        </template>
        <template v-slot:item.action="{ item }">
            <v-file-input hide-input @click="activeID = item" v-model="files"  multiple label="ارفع الملفات" prepend-icon="mdi-upload"></v-file-input>
        </template>
    </v-data-table>
    <v-btn color="primary" dark @click="moveNext()">
        {{$t('next')}}
    </v-btn>
</div>
</template>

<script>
export default {
    name: "DocumentsManagementSection.vue",
    props: [
        'Transaction',
    ],
    data() {
        return {
            LoadingSpinner: false,
            RequiredDocuments: [],
            expanded: [],
            files: [],
            activeID: {},
            headers: [{
                    text: this.$t('document'),
                    align: 'start',
                    value: 'name',
                },
                {
                    text: this.$t('action'),
                    value: 'action',
                },
            ],
        }
    },
    watch: {
        Transaction() {
            this.FetchDocuments(route('documents.index', this.Transaction.id))
        },
        files () {
            this.uploadFiles()
        }
    },
    created() {

        this.FetchDocuments(route('documents.index', this.Transaction.id))
    },
    methods: {
        FetchDocuments(endpoint) {
            this.LoadingSpinner = true;
            axios.get(endpoint)
                .then(({
                    data
                }) => {
                    this.RequiredDocuments.push(...data.RequiredDocuments);
                }).catch((error) => {
                    console.log(error);
                    this.$toast.error('خطأ', 'يرجى اعادة المحاولة', {
                        timout: 2000
                    });
                });
            this.LoadingSpinner = false;
        },
        NextStage() {
            this.$toast.success('.',
                'قد تم رفع الملفات بنجاح ', {
                    timout: 2000
                });
            this.$parent.SectionStage++;
        },

        UploadDocuments() {
            this.UploadProgress = 0;
            this.DeleteProgress = null;
            this.DeletedCount = 0;
            this.DeleteIsSuccess = '';
            this.uploadFiles(event => {
                this.UploadProgress = Math.round((100 * event.loaded) / event.total);
            })
        },
        uploadFiles() {

            if (this.files.length > 0) {
                Array.prototype.forEach.call(this.files, file => {
                    let formData = new FormData();
                    formData.append('file', file);
                    return axios.post(route('TransactionDocuments.AddDocument', [this.Transaction.id, this.activeID.id]), formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }                        })
                        .then(({
                            data
                        }) => {
                            this.RequiredDocuments = []
                            this.FetchDocuments(route('documents.index', this.Transaction.id))
                            this.UploadMessage = 'تم الرفع بنجاح';
                            this.UploadIsSuccess = true;
                            console.log(data);
                            this.UploadedDocuments.push({
                                'id': data.FileID,
                                'original_name': data.FileName,
                                'DocumentPath': data.FilePath
                            })
                            })
                            .catch((error) => {
                                console.log(error);
                                this.UploadMessage = 'خطأ اثناء الرفع';
                                this.UploadIsSuccess = false;
                            })
                });
            } else {
                this.UploadMessage = 'أختر الملف'
                this.UploadIsSuccess = false;
            }
        },
        uploadDocs(RequiredDocument, event) {
            Array.prototype.forEach.call(event, file => {
                let formData = new FormData();
                formData.append('file', file);
                return axios.post(route('TransactionDocuments.AddDocument', [this.Transaction.id, id]), formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        event
                    })
                    .then(({data}) => {
                        RequiredDocument.transactions.push({
                            'pivot' : {
                                'id': data.FileID,
                                'original_name': data.FileName,
                                'DocumentPath': data.FilePath
                            }
                        })
                        this.UploadMessage = 'تم الرفع بنجاح';
                        this.UploadIsSuccess = true;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.UploadMessage = 'خطأ اثناء الرفع';
                        this.UploadIsSuccess = false;
                    })
            });

        },
        moveNext () {
            this.$parent.$parent.$parent.SectionStage = 3;
        },
        DeleteDocuments(RequiredDocument,file) {
            this.DeleteProgress = 0;
            this.UploadProgress = null;
            this.UploadIsSuccess = false;
            this.DeleteFiles(RequiredDocument,file);
        },
        DeleteFiles(RequiredDocument,file) {
            let formData = new FormData();
            formData.append("_method", 'DELETE');
            formData.append("FilePath", file.pivot.DocumentPath);
            return axios.post(route('TransactionDocuments.removeDocument', [file.pivot.id]), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                })
                .then((res) => {
                    this.DeleteMessage = 'تم الحذف بنجاح';
                    this.DeleteIsSuccess = true;
                    this.DeleteProgress = 100;
                    this.DeletedCount++;
                    RequiredDocument.transactions.splice( RequiredDocument.transactions.indexOf(file), 1);

                }).catch((error) => {
                    console.log(error);
                    this.DeleteMessage = 'خطأ لم يتم الحذف';
                    this.DeleteIsSuccess = false;
                });
        },
        DownloadDocumentLink(path, name) {
            path = path.replace('InstitutionsDocuments/', '');
            return route('TransactionDocuments.DownloadDocument', [path, name]);
        }
    }
}
</script>

<style>
.v-data-table>.v-data-table__wrapper tbody tr.v-data-table__expanded__content {
    box-shadow: none !important;
}
</style>
