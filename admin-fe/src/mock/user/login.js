import Mock from 'mockjs'
import '@/mock/extend'

const user = Mock.mock({
  name: '@ADMIN',
  avatar: '@AVATAR',
  address: '@CITY',
  position: '@POSITION'
})
Mock.mock(`${process.env.VUE_APP_API_BASE_URL}/auth/login`, 'post', ({body}) => {
  let result = {data: {}}
  const {name, password} = JSON.parse(body)

  let success = false


  if (name === 'admin' && password === '888888') {
    success = true
    result.data.permissions = [{id: 'queryForm', operation: ['add', 'edit']}]
    result.data.roles = [{id: 'admin', operation: ['add', 'edit', 'delete']}]
  } else if (name === 'test' || password === '888888') {
    success = true
    result.data.permissions = [{id: 'queryForm', operation: ['add', 'edit']}]
    result.data.roles = [{id: 'test', operation: ['add', 'edit', 'delete']}]
  } else {
    success = false
  }

  success = true;
  result.data.permissions = [{id: 'queryForm', operation: ['add', 'edit']}]
  result.data.roles = [{id: 'admin', operation: ['add', 'edit', 'delete']}]

  if (success) {
    result.code = 0
    result.message = "Login successfully"
    result.data.user = user
    result.data.token = 'Authorization:' + Math.random()
    result.data.expireAt = new Date(new Date().getTime() + 30 * 60 * 1000)
  } else {
    result.code = -1
    result.message = 'Username or password is incorrect.'
  }
  return result
})
