<template>
  <common-layout>
    <div class="top">
      <div class="header">

        <span class="title">{{ systemName }}</span>
      </div>
      <div class="desc">Login With SuperAdmin Account</div>
    </div>
    <div class="login">
      <a-form @submit="onSubmit" :form="form">
        <a-tabs size="large" :tabBarStyle="{ textAlign: 'center' }" style="padding: 0 2px;">
          <a-tab-pane tab="Login with phone" key="1">
            <a-alert type="error" :closable="true" v-show="error" :message="error" showIcon
              style="margin-bottom: 24px;" />
            <a-form-item>
              <a-input autocomplete="autocomplete" size="large" placeholder="Phone"
                v-decorator="['name', { rules: [{ required: true, message: 'Phone is required', whitespace: true }] }]">
                <a-icon slot="prefix" type="user" />
              </a-input>
            </a-form-item>
            <a-form-item>
              <a-input size="large" placeholder="888888" autocomplete="autocomplete" type="password"
                v-decorator="['password', { rules: [{ required: true, message: 'Password is required', whitespace: true }] }]">
                <a-icon slot="prefix" type="lock" />
              </a-input>
            </a-form-item>
          </a-tab-pane>

        </a-tabs>
        <div>
          <!-- <a-checkbox :checked="true" >Auto login</a-checkbox> -->
          <!-- <a style="float: right">Forget password</a> -->
        </div>
        <a-form-item>
          <a-button :loading="logging" style="width: 100%;margin-top: 24px" size="large" htmlType="submit"
            type="primary">Login</a-button>
        </a-form-item>
        <!-- <div>
          其他登录方式
          <a-icon class="icon" type="alipay-circle" />
          <a-icon class="icon" type="taobao-circle" />
          <a-icon class="icon" type="weibo-circle" />
          <router-link style="float: right" to="/dashboard/analysis" >注册账户</router-link>
        </div> -->
      </a-form>
    </div>
  </common-layout>
</template>

<script>
import CommonLayout from '@/layouts/CommonLayout'
import { login } from '@/services/user'
import { setAuthorization } from '@/utils/request'
import { loadRoutes } from '@/utils/routerUtil'
import { mapMutations } from 'vuex'

export default {
  name: 'Login',
  components: { CommonLayout },
  data() {
    return {
      logging: false,
      error: '',
      form: this.$form.createForm(this)
    }
  },
  computed: {
    systemName() {
      return this.$store.state.setting.systemName
    }
  },
  methods: {
    ...mapMutations('account', ['setUser', 'setPermissions', 'setRoles']),
    onSubmit(e) {
      e.preventDefault()
      this.form.validateFields((err) => {
        if (!err) {
          this.logging = true
          const name = this.form.getFieldValue('name')
          const password = this.form.getFieldValue('password')
          login(name, password).then(this.afterLogin)
        }
      })
    },
    afterLogin(res) {
      try {
        this.logging = false
        const loginRes = res.data
        if (loginRes.status === "success") {
          const { user, authorisation } = loginRes
          const permissions = [{ id: 'queryForm', operation: ['add', 'edit'] }]
          const roles = [{ id: 'admin', operation: ['add', 'edit', 'delete'] }]
          this.setUser(user)
          this.setPermissions(permissions)
          this.setRoles(roles)
          setAuthorization({ token: authorisation.token, expireAt: new Date().getTime() + 1000 * 60 * 60 * 24 * 7 })
          // getRoutesConfig().then(result => {
          const routesConfig = [{
            router: 'root',
            children: [
              {
                router: 'dashboard',
                children: ['workplace', 'analysis'],
              },
              {
                router: 'form',
                children: ['basicForm', 'stepForm', 'advanceForm']
              },
              {
                router: 'basicForm',
                name: '验权表单',
                icon: 'file-excel',
                authority: 'queryForm'
              },
              {
                router: 'antdv',
                path: 'antdv',
                name: 'Ant Design Vue',
                icon: 'ant-design',
                link: 'https://www.antdv.com/docs/vue/introduce-cn/'
              },
              {
                router: 'document',
                path: 'document',
                name: '使用文档',
                icon: 'file-word',
                link: 'https://iczer.gitee.io/vue-antd-admin-docs/'
              }
            ]
          }]
          loadRoutes(routesConfig)
          this.$router.push('/dashboard/analysis')
          this.$message.success(loginRes.message, 3)
          //reload the page
          setTimeout(() => {
            window.location.reload()
          }, 1000)
          // })
        } else {
          this.error = loginRes.message
        }
      } catch (err) {
        console.log(err)
      }
    }
  }
}
</script>

<style lang="less" scoped>
.common-layout {
  .top {
    text-align: center;

    .header {
      height: 44px;
      line-height: 44px;

      a {
        text-decoration: none;
      }

      .logo {
        height: 44px;
        vertical-align: top;
        margin-right: 16px;
      }

      .title {
        font-size: 33px;
        color: @title-color;
        font-family: 'Myriad Pro', 'Helvetica Neue', Arial, Helvetica, sans-serif;
        font-weight: 600;
        position: relative;
        top: 2px;
      }
    }

    .desc {
      font-size: 14px;
      color: @text-color-second;
      margin-top: 12px;
      margin-bottom: 40px;
    }
  }

  .login {
    width: 368px;
    margin: 0 auto;

    @media screen and (max-width: 576px) {
      width: 95%;
    }

    @media screen and (max-width: 320px) {
      .captcha-button {
        font-size: 14px;
      }
    }

    .icon {
      font-size: 24px;
      color: @text-color-second;
      margin-left: 16px;
      vertical-align: middle;
      cursor: pointer;
      transition: color 0.3s;

      &:hover {
        color: @primary-color;
      }
    }
  }
}
</style>
