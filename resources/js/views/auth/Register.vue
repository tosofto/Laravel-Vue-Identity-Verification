<template>
  <form @submit.prevent="validateBeforeSubmit">
    <div class="user-registration-first-last-name">
      <div
        :class="[
          'form-group name-form',
          { 'is-invalid': $v.registerData.first_name.$error },
        ]"
      >
        <label for="signup-fist-name">First Name</label>
        <input
          :class="{
            'is-invalid': $v.registerData.first_name.$error,
            'form-group--loading': $v.registerData.first_name.$pending,
          }"
          v-model.lazy="registerData.first_name"
          class="form-control"
          placeholder="Enter First Name"
          type="text"
          id="signup-fist-name"
          @change="$v.registerData.first_name.$touch()"
        />
        <span
          v-if="!$v.registerData.first_name.required"
          class="invalid-feedback"
        >
          First Name is required.
        </span>
        <span
          v-if="!$v.registerData.first_name.minLength"
          class="invalid-feedback"
        >
          First Name must have at least
          {{ $v.registerData.first_name.$params.minLength.min }} letters.
        </span>
      </div>
      <div
        :class="[
          'form-group name-form',
          { 'is-invalid': $v.registerData.last_name.$error },
        ]"
      >
        <label for="signup-last-name">Last Name</label>
        <input
          :class="{
            'is-invalid': $v.registerData.last_name.$error,
            'form-group--loading': $v.registerData.last_name.$pending,
          }"
          v-model.lazy="registerData.last_name"
          class="form-control"
          placeholder="Enter Last Name"
          type="text"
          id="signup-last-name"
          @change="$v.registerData.last_name.$touch()"
        />
        <span
          v-if="!$v.registerData.last_name.required"
          class="invalid-feedback"
        >
          Last Name is required.
        </span>
        <span
          v-if="!$v.registerData.last_name.minLength"
          class="invalid-feedback"
        >
          Last Name must have at least
          {{ $v.registerData.last_name.$params.minLength.min }} letters.
        </span>
      </div>
    </div>
    <div
      :class="['form-group', { 'is-invalid': $v.registerData.email.$error }]"
    >
      <label for="signup-email">Email</label>
      <input
        :class="{
          'is-invalid': $v.registerData.email.$error,
          'form-group--loading': $v.registerData.email.$pending,
        }"
        v-model.trim.lazy="registerData.email"
        class="form-control"
        placeholder="Enter Email"
        type="email"
        id="signup-email"
        @change="$v.registerData.email.$touch()"
      />
      <span v-if="!$v.registerData.email.required" class="invalid-feedback">
        Email is required.
      </span>
      <span v-if="!$v.registerData.email.email" class="invalid-feedback">
        Please verify your email.
      </span>
      <span v-if="!$v.registerData.email.isUnique" class="invalid-feedback">
        This email is already registered.
      </span>
    </div>
    <div
      :class="['form-group', { 'is-invalid': $v.registerData.password.$error }]"
    >
      <label for="signup-password">Password</label>
      <input
        :class="{ 'is-invalid': $v.registerData.password.$error }"
        v-model.trim="registerData.password"
        class="form-control"
        placeholder="Enter Password"
        type="password"
        id="signup-password"
        @change="$v.registerData.password.$touch()"
      />
      <span v-if="!$v.registerData.password.required" class="invalid-feedback">
        Password is required.
      </span>
      <span v-if="!$v.registerData.password.minLength" class="invalid-feedback">
        Password must have at least
        {{ $v.registerData.password.$params.minLength.min }} letters.
      </span>
    </div>
    <div
      :class="[
        'form-group',
        { 'is-invalid': $v.registerData.password_confirmation.$error },
      ]"
    >
      <label for="signup-confirm-password">Confirm Password</label>
      <input
        :class="{ 'is-invalid': $v.registerData.password_confirmation.$error }"
        v-model.trim="registerData.password_confirmation"
        class="form-control"
        placeholder="Retype Password"
        id="signup-confirm-password"
        type="password"
        @change="$v.registerData.password_confirmation.$touch()"
      />
      <span
        v-if="!$v.registerData.password_confirmation.sameAsPassword"
        class="invalid-feedback"
      >
        Passwords must be identical.
      </span>
    </div>
    <div class="form-group">
      <label for="gender">Gender</label>
      <div
        class="form-group margin-top-0"
        :class="{ 'is-invalid': $v.registerData.gender.$error }"
      >
        <div
          class="form-check form-check-inline"
          :class="{
            'is-invalid': $v.registerData.gender.$error,
          }"
        >
          <input
            class="form-check-input"
            type="radio"
            name="gender"
            v-model="registerData.gender"
            id="gender1"
            value="male"
          />
          <label class="form-check-label" for="gender1">Male</label>
        </div>
        <div
          class="form-check form-check-inline"
          :class="{
            'is-invalid': $v.registerData.gender.$error,
          }"
        >
          <input
            class="form-check-input"
            type="radio"
            name="gender"
            v-model="registerData.gender"
            id="gender2"
            value="female"
          />
          <label class="form-check-label" for="gender2">Female</label>
        </div>
        <div v-if="$v.registerData.gender.$error" class="invalid-feedback">
          <span v-if="!$v.registerData.gender.required"
            >User Gender is required</span
          >
        </div>
      </div>
    </div>
    <vue-recaptcha
      sitekey="6LeCGCgfAAAAALRBFwy5jvvNPP1uEalYD5RkNa6N"
      :loadRecaptchaScript="true"
      ref="recaptcha"
      type="visible"
      @verify="onCaptchaVerified"
      @expired="onCaptchaExpired"
      class="register-recaptcha"
    >
    </vue-recaptcha>
    <div class="form-group">
      <div
        class="form-group margin-top-0"
        :class="{ 'is-invalid': $v.registerData.terms.$error }"
      >
        <div
          class="form-check form-check-inline"
          :class="{
            'is-invalid': $v.registerData.terms.$error,
          }"
        >
          <input
            class="form-check-input"
            type="checkbox"
            name="terms"
            v-model="registerData.terms"
            id="terms"
          />
        </div>
        <label class="form-check-label" for="terms"
          >I accept <a href="#">Terms & Conditions</a></label
        >
        <div
          v-if="$v.registerData.terms.$error"
          class="invalid-feedback terms_conditions"
        >
          <span v-if="!$v.registerData.terms.required"
            >Please accept terms & conditions is required</span
          >
        </div>
      </div>
    </div>
    <button class="btn btn-login btn-full">Register</button>
    <div class="ivp-to-login">
      <span>Already have an account?</span>
      <router-link to="/login">Sign in.</router-link>
    </div>
  </form>
</template>
<script>
import { VueRecaptcha } from "vue-recaptcha";
import Auth from "../../services/auth";
import { required, minLength, email, sameAs } from "vuelidate/lib/validators";

export default {
  name: "register",
  data() {
    return {
      registerData: {
        first_name: "Alex",
        last_name: "Rossi",
        email: "",
        password: "",
        password_confirmation: "",
        gender: "male",
        recaptcha: "",
        terms: true,
      },
      loadingPage: true,
      validateCaptcha: false,
    };
  },
  mounted() {
    this.loadingPage = false;
  },
  validations: {
    registerData: {
      first_name: {
        required,
        minLength: minLength(3),
      },
      last_name: {
        required,
        minLength: minLength(3),
      },
      password: {
        required,
        minLength: minLength(6),
      },
      password_confirmation: {
        sameAsPassword: sameAs("password"),
      },
      email: {
        required,
        email,
        async isUnique(value) {
          // standalone validator ideally should not assume a field is required
          if (value === "") return true;

          // simulate async call, fail for all logins with even length
          let response = await window.axios.post("/api/email-exist", {
            email: value,
          });
          return response.data;
        },
      },
      gender: {
        required,
      },
      terms: {
        required,
      },
    },
  },
  components: { VueRecaptcha },
  methods: {
    validateBeforeSubmit() {
      this.loadingPage = true;
      this.$v.$touch();
      if (!this.$v.$error && this.validateCaptcha == true) {
        Auth.register(this.registerData).then((res) => {
          if (res) {
            this.loadingPage = false;
            this.$router.push("/admin/dashboard/basic");
          }
        });
      } else if (this.validateCaptcha == false) {
        window.toastr["error"]("Please pass reCaptcha", "Error");
      }
    },
    onCaptchaVerified(recaptchaToken) {
      this.registerData.recaptcha = recaptchaToken;
      this.validateCaptcha = true;
    },
    onCaptchaExpired() {
      this.$refs.recaptcha.reset();
    },
  },
};
</script>

<style scoped>
.form-group {
  position: relative;
  margin-top: 30px;
}
.form-group label {
  margin: 0px;
  margin-bottom: 5px;
}
.login-page .login-box .form-control {
  margin: 0px;
}
.ivp-to-login {
  margin-top: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.ivp-to-login span {
  margin-right: 10px;
}
.invalid-feedback {
  position: absolute;
  top: 75px;
  text-align: center;
}
.btn-login {
  margin-top: 15px;
}
.margin-top-0 {
  margin-top: 0px;
  display: flex;
  align-items: center;
}
.margin-top-0 label {
  margin: 0px !important;
}
.margin-top-0 div {
  margin-right: 5px;
}
.register-recaptcha {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 10px;
}
.user-registration-first-last-name {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 30px;
}
.user-registration-first-last-name .form-group {
  width: 48%;
}
.terms_conditions {
  top: 20px !important;
}
.name-form {
  margin: 0px;
}
</style>
