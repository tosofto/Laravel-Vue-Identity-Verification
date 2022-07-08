<template>
  <div class="login-page login-1">
    <div class="login-wrapper">
      <div class="login-box">
        <div class="logo-main">
          <a href="/admin">
            <img src="/assets/img/logo.png" alt="Laraspace Logo" />
          </a>
        </div>
        <h1>Identity Verification Portal</h1>
        <router-view />
      </div>
    </div>
  </div>
</template>

<style scoped>
.login-page .logo-main img {
  height: auto;
  width: 120px;
}
.login-page .login-box {
  color: #fff;
  padding: 20px;
  width: 100%;
  max-width: 600px;
}
.login-page .login-box h1 {
  color: white;
  text-align: center;
}
</style>

<style>
.toast-success {
  /* background-color: #51a351; */
  background-color: #51a351 !important;
}
.toast-info {
  background-color: #2f96b4;
}
.toast-error {
  background-color: #bd362f !important;
}
</style>
