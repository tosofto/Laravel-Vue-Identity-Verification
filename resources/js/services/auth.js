import Ls from './ls'

export default {
  async login(loginData) {
    try {
      let response = await axios.post('/api/auth/login', loginData)
      Ls.set('auth.token', response.data.token.token)
      Ls.set('user_id', response.data.user_data[0].id)
      Ls.set('First Name', response.data.user_data[0].first_name)
      Ls.set('Last Name', response.data.user_data[0].last_name)
      Ls.set('Email', response.data.user_data[0].email)
      Ls.set('Role', response.data.user_data[0].role)
      Ls.set('Gender', response.data.user_data[0].gender)
      toastr['success']('Logged In!', 'Success')
      return response.data.token.token
    } catch (error) {
      if (error.response.status === 401) {
        toastr['error']('Invalid Credentials', 'Error')
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message)
      }
    }
  },

  async register(registerData) {
    try {
      let response = await axios.post('/api/auth/register', registerData)
      toastr['success']('A new ' + response.data.role + ' has been registered!', 'Success')
      Ls.set('First Name', response.data.first_name)
      Ls.set('Last Name', response.data.last_name)
      Ls.set('Email', response.data.email)
      Ls.set('Role', response.data.role)
      Ls.set('Gender', response.data.gender)
      Ls.set('Registered_User', true)
      return response.data
    } catch (error) {
      toastr['error']('Error Occurred in registered!', 'Error')
    }
  },

  async addNewMemberRegister(registerData) {
    try {
      let response = await axios.post('/api/auth/new/register', registerData)
      // toastr['success']('A new ' + response.data.role + ' has been registered!', 'Success')
      return response.data
    } catch (error) {
      toastr['error']('Error Occurred in registered!', 'Error')
    }
  },

  async logout() {
    try {
      await axios.get('/api/auth/logout')

      Ls.remove('user_id')
      Ls.remove('auth.token')
      Ls.remove('First Name')
      Ls.remove('Last Name')
      Ls.remove('Email')
      Ls.remove('Role')
      Ls.remove('Gender')
      Ls.remove('user_avatar')
      Ls.remove('Registered_User')
      toastr['success']('Logged out!', 'Success')
    } catch (error) {
      console.log('Error', error.message)
    }
  },

  async check() {
    let response = await axios.get('/api/auth/check')

    return !!response.data.authenticated
  }
}
