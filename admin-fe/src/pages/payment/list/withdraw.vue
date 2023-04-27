
<template>
    <div>
        <a-card>
            <a-row style="display: flex; justify-content: space-between;">
                <div>
                    <a-button @click="setDateFilter('today')">
                        Today
                    </a-button>
                    <a-button @click="setDateFilter('yesterday')">
                        Yesterday
                    </a-button>
                    <a-button @click="setDateFilter('week')">
                        Week
                    </a-button>
                    <a-button @click="setDateFilter('month')">
                        Month
                    </a-button>
                    <a-button @click="setDateFilter('clear')">
                        Clear
                    </a-button>
                </div>
                <a-button @click="handleAcceptAll">
                    Appect All
                </a-button>
            </a-row>
        </a-card>
        <a-card>
            <div>
                <a-space class="operator">
                    <!-- <a-button @click="addNew" type="primary">Add new</a-button> -->
                    <!-- <a-dropdown>
                          <a-menu @click="handleMenuClick" slot="overlay">
                            <a-menu-item key="delete">删除</a-menu-item>
                            <a-menu-item key="audit">审批</a-menu-item>
                          </a-menu>
                          <a-button> 更多操作 <a-icon type="down" /> </a-button>
                        </a-dropdown> -->
                </a-space>
                <standard-table :columns="columns" :dataSource="dataSource"
                    :pagination="{ ...pagination, onChange: onPageChange }">
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

                    <div slot="date-public-column" slot-scope="date_public">

                        <div>
                            <p>{{ formatTime(date_public.text) }}</p>
                        </div>
                    </div>
                    <div slot="date-end-column" slot-scope="date_end">

                        <div>
                            <p>{{ formatTime(date_end.text) }}</p>
                        </div>
                    </div>
                    <div slot="action" slot-scope="{  record }">
                        <a @click="checkRecord(record.id, 1)">
                            <a-icon type="check" />
                            Approve
                        </a>
                        <a @click="checkRecord(record.id, 2)">
                            <a-icon type="stop" />
                            Refuse
                        </a>
                    </div>
                    <template slot="statusTitle">
                        <a-icon @click.native="onStatusTitleClick" type="info-circle" />
                    </template>
                </standard-table>
            </div>
        </a-card>
    </div>
</template>

<script>


import StandardTable from "@/components/table/StandardTable";
import { request } from "@/utils/request";
import moment from "moment";
import { formatCurrencyVND } from "@/utils/util";

const columns = [
    {
        title: "User",
        dataIndex: "user_name",
    },
    {
        title: "Id User",
        dataIndex: "user",
    },
    {
        title: "Reason",
        dataIndex: "name",
        width: "20%",
    },
    {
        title: "Amount",
        dataIndex: "amount",
    },
    {
        title: "Status",
        dataIndex: "status",
    },
    {
        title: "Created At",
        dataIndex: "created_at",
    },
    {
        title: "Review at",
        dataIndex: "updated_at",
        key: "updated_at",

    },
    {
        title: "Reason Reject",
        dataIndex: "reason",
    },
    {
        title: "Action",
        scopedSlots: { customRender: "action" },
    },
];

export default {
    name: "QueryList",
    components: { StandardTable },
    data() {
        return {
            advanced: true,
            columns: columns,
            data: [],
            dataSource: [],
            selectedRows: [],
            pagination: {
                current: 1,
                pageSize: 10,
                total: 0,
            },
        };
    },
    // authorize: {
    //   deleteRecord: "delete",
    // },
    mounted() {
        this.getData();
    },
    methods: {
        formatTime(time) {
            const result = moment(time).format("DD-MM-YYYY");
            if (result === "Invalid date") {
                return "no date";
            }
            return result
        },
        handleAcceptAll() {
            const confirm = window.confirm("Are you sure?");
            if (!confirm) {
                return;
            }
            request(process.env.VUE_APP_API_BASE_URL + "/withdraw/accept-all", "put", {}).then(() => {
                this.getData();
                this.$message.success(`Update successfully`);
            });
        },
        onPageChange(page, pageSize) {
            this.pagination.current = page;
            this.pagination.pageSize = pageSize;
            this.getData();
        },
        getData() {
            request(process.env.VUE_APP_API_BASE_URL + "/withdraw", "get", {
                page: this.pagination.current,
                pageSize: this.pagination.pageSize,
            }).then((res) => {
                const { data, current_page: page, per_page: pageSize, total } = res?.data?.items ?? {};
                this.data = data.map(_data => {
                    return {
                        ..._data,
                        amount: _data.amount ? formatCurrencyVND(_data.amount) : 0 + "đ",
                        status: !_data.status ? "Pending" : _data.status === 1 ? "Approved" : "Rejected",
                        created_at: _data.created_at ? moment(_data.created_at).format("DD-MM-YYYY MM:HH") : "no date",
                        updated_at: _data.updated_at ? moment(_data.updated_at).format("DD-MM-YYYY MM:HH") : "no date",
                    }
                })
                this.dataSource = this.data;

                this.pagination.current = page;
                this.pagination.pageSize = pageSize;
                this.pagination.total = total;
            });
        },
        checkRecord(id, status) {
            let reason = "";
            if (status == 2) {
                reason = prompt("Please enter the reason for refusal", "");
                if (reason == null || reason == "") {
                    return;
                }
            }
            const confirm = window.confirm("Are you sure?");
            if (!confirm) {
                return;
            }
            request(process.env.VUE_APP_API_BASE_URL + "/recharge/" + id, "put", {
                status,
                reason,
            }).then(() => {
                this.getData();
                this.$message.success(`Update successfully`);
            });
        },
        setDateFilter(unit) {
            const now = moment();
            switch (unit) {
                case 'today':
                    this.dataSource = this.data.filter(
                        (item) => moment(item.created_at).isSame(now, 'day')
                    );
                    break;
                case 'yesterday':
                    this.dataSource = this.data.filter(
                        (item) => moment(item.created_at).isSame(now.subtract(1, 'days'), 'day')
                    );
                    break;
                case 'week':
                    this.dataSource = this.data.filter(
                        (item) => moment(item.created_at).isSame(now, 'week')
                    );
                    break;
                case 'month':
                    this.dataSource = this.data.filter(
                        (item) => moment(item.created_at).isSame(now, 'month')
                    );
                    break;
                default:
                    this.dataSource = this.data;
            }
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
