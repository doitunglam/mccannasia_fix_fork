<template>
  <div class="analysis">
    <a-row style="margin-top: 0" :gutter="[24, 24]">
      <a-col :sm="24" :md="12" :xl="6">
        <chart-card :loading="loading" :title="$t('totalSales')" :total="totalRecharge">
          <a-tooltip :title="$t('introduce')" slot="action">
            <a-icon type="info-circle-o" />
          </a-tooltip>
        </chart-card>
      </a-col>
      <a-col :sm="24" :md="12" :xl="6">
        <chart-card :loading="loading" :title="$t('visits')" :total="totalWithdraw">
          <a-tooltip :title="$t('introduce')" slot="action">
            <a-icon type="info-circle-o" />
          </a-tooltip>
        </chart-card>
      </a-col>
      <a-col :sm="24" :md="12" :xl="6">
        <chart-card :loading="loading" :title="$t('payments')" :total="analysisData.totalUserRegisterToday">
          <a-tooltip :title="$t('introduce')" slot="action">
            <a-icon type="info-circle-o" />
          </a-tooltip>
        </chart-card>
      </a-col>
    </a-row>
    <a-card :loading="loading" style="margin-top: 24px" :bordered="false" :body-style="{ padding: '24px' }">
      <div class="salesCard">
        <a-tabs default-active-key="1" size="large" :tab-bar-style="{ marginBottom: '24px', paddingLeft: '16px' }">
          <div class="extra-wrap" slot="tabBarExtraContent">
            <div class="extra-item">
              <a @click="setTime('day')">{{ $t('day') }}</a>
              <a @click="setTime('week')">{{ $t('week') }}</a>
              <a @click="setTime('month')">{{ $t('month') }}</a>
              <a @click="setTime('year')">{{ $t('year') }}</a>
            </div>
            <a-range-picker :style="{ width: '256px' }" v-model="myCustomDate"></a-range-picker>
          </div>
          <a-tab-pane loading="true" :tab="$t('mostAgency')" key="1">
            <a-row>
              <a-col>
                <ranking-list :list="mostAgency" />
              </a-col>
            </a-row>
          </a-tab-pane>
          <a-tab-pane loading="true" :tab="$t('recharge')" key="2">
            <a-row>
              <a-col>
                <ranking-list :list="recharge" />
              </a-col>
            </a-row>
          </a-tab-pane>
          <a-tab-pane loading="true" :tab="$t('withdraw')" key="3">
            <a-row>
              <a-col>
                <ranking-list :list="withdraw" />
              </a-col>
            </a-row>
          </a-tab-pane>
          <a-tab-pane loading="true" :tab="$t('rechargePending')" key="4">
            <a-row>
              <a-col>
                <ranking-list :list="rechargePending" />
              </a-col>
            </a-row>
          </a-tab-pane>
          <a-tab-pane loading="true" :tab="$t('withdrawPending')" key="5">
            <a-row>
              <a-col>
                <ranking-list :list="withdrawPending" />
              </a-col>
            </a-row>
          </a-tab-pane>
        </a-tabs>
      </div>
    </a-card>
  </div>
</template>

<script>
/* eslint-disable vue/no-unused-components */
import ChartCard from '../../../components/card/ChartCard'
import MiniArea from '../../../components/chart/MiniArea'
import MiniBar from '../../../components/chart/MiniBar'
import MiniProgress from '../../../components/chart/MiniProgress'
import Bar from '../../../components/chart/Bar'
import RankingList from '../../../components/chart/RankingList'
import HotSearch from './HotSearch'
import SalesData from './SalesData'
import { request } from "@/utils/request";
import Trend from '../../../components/chart/Trend'
import { formatCurrencyVND } from '../../../utils/util'
import moment from 'moment';

const rankList = []

for (let i = 0; i < 8; i++) {
  rankList.push({
    name: '桃源村' + i + '号店',
    total: 1234.56 - i * 100
  })
}

export default {
  name: 'Analysis',
  i18n: require('./i18n'),
  data() {
    return {
      analysisData: {},
      rankList,
      mostAgency: [],
      recharge: [],
      withdraw: [],
      rechargePending: [],
      withdrawPending: [],
      totalRecharge: "",
      totalWithdraw: "",
      totalRegister: "",
      loading: true,
      from: null,
      to: null,
      myCustomDate: [null, null]
    }
  },
  mounted() {
    this.getData();
  },
  watch: {
    myCustomDate: function (val) {
      if (val[0] && val[1]) {
        this.from = val[0].toISOString()
        this.to = val[1].toISOString()
        this.getData()
      }
    }
  },
  methods: {
    formatCurrencyVND(value) {
      return formatCurrencyVND(value)
    },
    setTime(time) {
      switch (time) {
        case 'day':
          this.from = moment().startOf('day').toISOString()
          this.to = moment().endOf('day').toISOString()
          break;
        case 'week':
          this.from = moment().subtract(7, 'days').toISOString()
          this.to = moment().toISOString()
          break;
        case 'month':
          this.from = moment().subtract(1, 'months').toISOString()
          this.to = moment().toISOString()
          break;
        case 'year':
          this.from = moment().subtract(1, 'years').toISOString()
          this.to = moment().toISOString()
          break;
      }
      this.getData()
    },
    getData() {
      let uri = process.env.VUE_APP_API_BASE_URL + "/analysis"
      if(this.from && this.to) {
        uri += `?from=${this.from}&to=${this.to}`
      }
      console.log(uri)
      request(uri, "get", {
      }).then((res) => {
        const { data } = res?.data ?? {};
        this.analysisData = data
        this.totalRecharge = formatCurrencyVND(data?.totalRechargeAmountToday)
        this.totalWithdraw = formatCurrencyVND(data?.totalWithdrawAmountToday)
        this.mostAgency = data?.topByReferralCode.map((item) => {
          return {
            name: item.name,
            total: item.user_count
          }
        })
        this.recharge = data?.topByRechargeAmount.map((item) => {
          return {
            name: item.name,
            total: formatCurrencyVND(item.total_recharge_amount)
          }
        })
        this.withdraw = data?.topByWithdrawAmount.map((item) => {
          return {
            name: item.name,
            total: formatCurrencyVND(item.total_withdraw_amount)
          }
        })
        this.rechargePending = data?.topRechargePending.map((item) => {
          return {
            name: item.name,
            total: formatCurrencyVND(item.amount)
          }
        })
        this.withdrawPending = data?.topWithdrawPending.map((item) => {
          return {
            name: item.name,
            total: formatCurrencyVND(item.amount)
          }
        })
      });
    },
  },
  created() {
    setTimeout(() => this.loading = !this.loading, 1000)
  },
  components: { Trend, SalesData, HotSearch, RankingList, Bar, MiniProgress, MiniBar, MiniArea, ChartCard }
}
</script>

<style lang="less" scoped>
.extra-wrap {
  .extra-item {
    display: inline-block;
    margin-right: 24px;

    a:not(:first-child) {
      margin-left: 24px;
    }
  }
}

@media screen and (max-width: 992px) {
  .extra-wrap .extra-item {
    display: none;
  }
}

@media screen and (max-width: 576px) {
  .extra-wrap {
    display: none;
  }
}
</style>
