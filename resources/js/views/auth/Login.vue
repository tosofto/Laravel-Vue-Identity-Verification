<template>
  <form @submit.prevent="validateBeforeSubmit">
    <div :class="['form-group', { 'is-invalid': $v.loginData.email.$error }]">
      <label class="login-label" for="login-email"
        ><i class="fa fa-envelope" aria-hidden="true"></i>
      </label>
      <input
        :class="{ 'is-invalid': $v.loginData.email.$error }"
        v-model.trim="loginData.email"
        class="form-control"
        placeholder="Enter Email"
        type="email"
        id="login-email"
        @input="$v.loginData.email.$touch()"
      />
      <span v-if="!$v.loginData.email.required" class="invalid-feedback">
        Email is required
      </span>
      <span v-if="!$v.loginData.email.email" class="invalid-feedback">
        Email is invalid
      </span>
    </div>
    <div
      :class="['form-group', { 'is-invalid': $v.loginData.password.$error }]"
    >
      <label class="login-label" for="login-password"
        ><i class="fa fa-key" aria-hidden="true"></i>
      </label>
      <input
        :class="{ 'is-invalid': $v.loginData.password.$error }"
        v-model.trim="loginData.password"
        class="form-control"
        placeholder="Enter Password"
        type="password"
        id="login-password"
        @input="$v.loginData.password.$touch()"
      />
      <span v-if="!$v.loginData.password.required" class="invalid-feedback">
        Password is required
      </span>
      <span v-if="!$v.loginData.password.minLength" class="invalid-feedback">
        Password must have at least
        {{ $v.loginData.password.$params.minLength.min }} letters.
      </span>
    </div>
    <vue-recaptcha
      v-if="recaptchaEnable"
      sitekey="6LeCGCgfAAAAALRBFwy5jvvNPP1uEalYD5RkNa6N"
      :loadRecaptchaScript="true"
      ref="recaptcha"
      type="visible"
      @verify="onCaptchaVerified"
      @expired="onCaptchaExpired"
      class="login-recaptcha"
    >
    </vue-recaptcha>
    <div class="other-actions row">
      <div class="col-sm-6">
        <div class="checkbox">
          <label class="c-input c-checkbox">
            <input
              v-model="loginData.remember"
              type="checkbox"
              name="remember"
            />
            <span class="c-indicator" />
            Remember Me
          </label>
        </div>
      </div>
      <div class="col-sm-6 text-sm-right">
        <a href="/password-reset" class="forgot-link"> Forgot Password? </a>
      </div>
    </div>
    <button class="btn btn-theme btn-full">Login</button>
    <div class="ivp-to-register">
      <span>New here?</span>
      <router-link to="/register">Create an Account</router-link>
    </div>
  </form>
</template>

<script>
import { VueRecaptcha } from "vue-recaptcha";
import { required, minLength, email } from "vuelidate/lib/validators";
import Auth from "../../services/auth";
import Ls from "./../../services/ls.js";

export default {
  data() {
    return {
      loginData: {
        email: "admin@laraspace.in",
        password: "admin@123",
        remember: true,
        recaptcha: "",
      },
      loadingPage: true,
      validateCaptcha: false,
      recaptchaEnable: true,
    };
  },
  mounted() {
    this.loadingPage = false;
  },
  validations: {
    loginData: {
      password: {
        required,
        minLength: minLength(6),
      },
      email: {
        required,
        email,
      },
    },
  },
  components: { VueRecaptcha },
  methods: {
    validateBeforeSubmit() {
      this.$v.$touch();

      if (!this.$v.$error && this.validateCaptcha == true) {
        Auth.login(this.loginData).then((res) => {
          if (res) {
            if (Ls.get("Role") == "admin" || Ls.get("Role") == "sub_admin") {
              this.$router.push("/admin/users/all");
            } else if (Ls.get("Role") == "practitioner") {
              let user_id = Ls.get("user_id");
              this.$router.push("/admin/users/profile/" + user_id);
            }
          }
        });
      } else if (this.validateCaptcha == false) {
        window.toastr["error"]("Please pass reCaptcha", "Error");
      }
    },
    onCaptchaVerified(recaptchaToken) {
      this.loginData.recaptcha = recaptchaToken;
      this.validateCaptcha = true;
    },
    onCaptchaExpired() {
      this.$refs.recaptcha.reset();
    },
  },
  created() {
    if (Ls.get("Email") !== null) {
      var email = Ls.get("Email");
      this.loginData.email = email;
    }
    if (Ls.get("auth.token") !== null) {
      if (Ls.get("Role") == "practitioner") {
        let user_id = Ls.get("user_id");
        this.$router.push("/admin/users/profile/" + user_id);
      } else {
        this.$router.push("/admin/users/all");
      }
    }
    let registeredStatus = Ls.get("Registered_User");
    if (registeredStatus) {
      this.recaptchaEnable = false;
    } else {
      this.recaptchaEnable = true;
    }
  },
};
</script>

<style scoped>
.form-group {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 40px;
  position: relative;
}
.form-group label {
  margin: 0px;
  margin-right: 10px;
  width: 90px;
}
.login-page .login-box .form-control {
  margin: 0px;
}
.ivp-to-register {
  margin-top: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.ivp-to-register span {
  margin-right: 10px;
}
.invalid-feedback {
  position: absolute;
  top: 45px;
  text-align: center;
}
.login-page .login-box .other-actions {
  margin-top: 40px;
}
</style>
<style>
.btn-theme {
  color: #212529;
  background-color: #ffde00;
  border-color: #ffde00;
  -o-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15),
    0 1px 1px rgba(0, 0, 0, 0.075);
  -ms-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15),
    0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-box-shadow: inset 0 1px 0 rgb(255 255 255 / 15%),
    0 1px 1px rgb(0 0 0 / 8%);
  box-shadow: inset 0 1px 0 rgb(255 255 255 / 15%), 0 1px 1px rgb(0 0 0 / 8%);
}
.login-recaptcha {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 40px;
}
.login-label {
  display: flex;
  align-items: center;
  justify-content: center;
  height: calc(1.5em + 0.75rem + 2px);
  background-color: white;
  border-radius: 5px 0px 0px 5px;
  padding-left: 5px;
  padding-right: 5px;
  position: relative;
  left: 5px;
  width: 60px !important;
  border-right: 1px black solid;
  margin: 0px !important;
}
.login-label i {
  font-size: 24px;
  color: #585459;
}
</style>
