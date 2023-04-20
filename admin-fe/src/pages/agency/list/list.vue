
<template>
    <div>
        <a-card>
            <a-row>

            </a-row>
        </a-card>
        <a-card>
            <div>
                <a-space class="operator">
                    <a-input v-model="searchText" placeholder="Name, Email, Phone" />
                </a-space>
                <standard-table :columns="columns" :dataSource="filteredData">
                    <template slot="image-column" slot-scope="image">
                        <img :src="image.text" />
                    </template>
                    <template slot="status-column" slot-scope="status">
                        <span v-if="status.text != 1" style="
                                                        background-color: green;
                                                        color: white;
                                                        padding: 4px 8px;
                                                        border-radius: 4px;
                                                        display: inline-block;
                                                    ">
                            active
                        </span>
                        <span v-if="status.text == 1" style="
                                                        background-color: red;
                                                        color: white;
                                                        padding: 4px 8px;
                                                        border-radius: 4px;
                                                        display: inline-block;
                                                    ">
                            inactive
                        </span>
                    </template>

                    <div slot="description" slot-scope="{ text }">
                        {{ text }}
                    </div>
                    <div slot="status" slot-scope="{ text }">
                        {{ text == 1 ? 'Blocked' : 'Unblock' }}
                    </div>
                    <div style="display: flex; flex-direction: column;" slot="action" slot-scope="{  record }">
                        <a @click="watchRecord(record.id)">
                            <a-icon type="eye" />
                            Watch
                        </a>
                        <a style="margin-right: 8px">
                            <a-icon type="edit" />
                            <router-link :to="`/partners/new?id=${record.id}`"> Edit
                            </router-link>
                        </a>
                        <a @click="blockRecord(record.id)">
                            <a-icon type="stop" />
                            Block
                        </a>
                        <a @click="changeAmountRecord(record.id)">
                            <a-icon type="money-collect" />
                            Amount
                        </a>
                        <a @click="resetPassword(record.id)">
                            <a-icon type="redo" />
                            Reset Pw
                        </a>
                    </div>
                    <template slot="statusTitle">
                        <a-icon @click.native="onStatusTitleClick" type="info-circle" />
                    </template>
                </standard-table>
            </div>
        </a-card>
        <modal :id="idSelected" :showModal="showModal" @update:showModal="(event) => {
            showModal = event; if (!event) {
                getData();
            }
        }"></modal>
        <modal-info  :idSelected2="idSelected2" :showModal="showModalInfo" @update:showModal="(event) => {
            showModalInfo = event
        }"></modal-info>
    </div>
</template>

<script>


import StandardTable from "@/components/table/StandardTable";
import { request } from "@/utils/request";
import moment from "moment";
import { formatCurrencyVND } from "@/utils/util";
import { METHOD } from "../../../utils/request";
import Modal from './modal.vue'
import ModalInfo from './modal-info.vue'

const columns = [
    {
        title: "ID",
        dataIndex: "id",
    },
    {
        title: "Name",
        dataIndex: "name",
        width: "20%",
    },
    {
        title: "Email",
        dataIndex: "email",
    },
    {
        title: "Amount",
        dataIndex: "amount",
    },
    {
        title: "Recharge",
        dataIndex: "sum_recharge",
    },
    {
        title: "Withdraw",
        dataIndex: "sum_withdraw",
    },
    {
        title: "Phone",
        dataIndex: "phone",
    },
    {
        title: "Agency of",
        dataIndex: "agencyOf",
    },
    {
        title: "Last login",
        dataIndex: "last_login_info",
    },
    {
        title: "Status",
        dataIndex: "status",
        scopedSlots: { customRender: "status" },
    },
    {
        title: "Action",
        scopedSlots: { customRender: "action" },
    },
];

export default {
    name: "QueryList",
    components: { StandardTable, Modal, ModalInfo },
    data() {
        return {
            advanced: true,
            columns: columns,
            dataSource: [],
            selectedRows: [],
            idSelected: "",
            idSelected2: "",
            showModal: false,
            showModalInfo: false,
            searchText: ""
        };
    },
    // authorize: {
    //   deleteRecord: "delete",
    // },
    mounted() {
        this.getData();
    },
    computed: {
        filteredData() {
            return this.dataSource.filter(item => {
                const searchText = this.searchText.toLowerCase()
                return item.name.toLowerCase().includes(searchText) || item.email.toLowerCase().includes(searchText) || item.phone.toLowerCase().includes(searchText)
            })
        },
    },
    methods: {
        getData() {
            request(process.env.VUE_APP_API_BASE_URL + "/agency", "get", {

            }).then((res) => {
                const data = res?.data?.items ?? {};
                const allUser = res?.data?.allUser.reduce((acc, cur) => {
                    acc[cur.referral_code] = cur;
                    return acc;
                }, {})

                this.dataSource = data.map((_data) => {
                    return {
                        ..._data,
                        last_login_info: (_data.last_login_time && _data.last_login_ip) ? moment(_data.last_login_time).format("YYYY-MM-DD HH:mm:ss") + ` (${_data.last_login_ip})` : "",
                        amount: _data.amount ? formatCurrencyVND(_data.amount) : 0,
                        sum_recharge: _data.sum_recharge ? formatCurrencyVND(_data.sum_recharge) : 0,
                        sum_withdraw: _data.sum_withdraw ? formatCurrencyVND(_data.sum_withdraw) : 0,
                        agencyOf: allUser[_data.parent_referral_code] ? allUser[_data.parent_referral_code].name : ""
                    }
                })
            });
        },
        watchRecord(id) {
            this.idSelected2 = id;
            this.showModalInfo = true;
        },
        blockRecord(id) {
            request(process.env.VUE_APP_API_BASE_URL + "/agency/block/" + id, METHOD.PUT).then(() => {
                this.getData();
                this.$message.success("Block/Unblock success");
            })
        },
        deleteRecord(id) {
            this.dataSource = this.dataSource.filter((item) => item.id !== id);
            this.selectedRows = this.selectedRows.filter((item) => item.id !== id);
        },
        changeAmountRecord(id) {
            this.idSelected = id;
            this.showModal = true;
        },
        resetPassword(id) {
            request(process.env.VUE_APP_API_BASE_URL + "/agency/reset-password/" + id, METHOD.PUT).then(() => {
                this.getData();
                this.$message.success("Reset password success");
            });
        },
        toggleAdvanced() {
            this.advanced = !this.advanced;
        },
        remove() {
            this.dataSource = this.dataSource.filter(
                (item) =>
                    this.selectedRows.findIndex((row) => row.key === item.key) === -1
            );
            this.selectedRows = [];
        },
        addNew() {
            this.dataSource.unshift({
                key: this.dataSource.length,
                no: "NO " + this.dataSource.length,
                description: "这是一段描述",
                callNo: Math.floor(Math.random() * 1000),
                status: Math.floor(Math.random() * 10) % 4,
                updatedAt: "2018-07-26",
            });
        },
        handleMenuClick(e) {
            if (e.key === "delete") {
                this.remove();
            }
        },
    },
};
</script>

<style lang="less" scoped>
.search {
    margin-bottom: 54px;
}

.fold {
    width: calc(100% - 216px);
    display: inline-block;
}

.operator {
    margin-bottom: 18px;
}

@media screen and (max-width: 900px) {
    .fold {
        width: 100%;
    }
}
</style>
