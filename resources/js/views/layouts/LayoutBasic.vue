<template>
  <div class="template-container">
    <site-header :user_avatar="user_avatar" />
    <site-sidebar
      type="basic"
      v-if="user_role === 'admin' || user_role === 'regional_admin'"
      :toggle="toggleEnable"
    />
    <div
      v-if="user_role === 'admin' || user_role === 'regional_admin'"
      class="side-bar-toggle d-none d-md-inline"
      :class="toggleEnable == true ? 'side-bar-toggle-enable' : ''"
    >
      <button @click="toggleSidebar" class="heart animated css">
        <i class="fa-solid fa-angles-left"></i>
      </button>
    </div>
    <transition name="fade" mode="out-in">
      <router-view
        :toggle="toggleEnable"
        @userAvatarChange="onUserAvatarChange"
      />
    </transition>
    <site-footer />
  </div>
</template>
<script type="text/babel">
import SiteHeader from "./partials/TheSiteHeader.vue";
import SiteFooter from "./partials/TheSiteFooter.vue";
import SiteSidebar from "./partials/TheSiteSidebar.vue";
import Ls from "./../../services/ls.js";
export default {
  data() {
    return {
      user_role: "",
      user_avatar: "",
      toggleEnable: false,
    };
  },
  components: {
    SiteHeader,
    SiteSidebar,
    SiteFooter,
  },
  mounted() {
    this.$utils.setLayout("default");
  },
  created() {
    this.user_role = Ls.get("Role");
    this.toggleEnable = false;
  },
  methods: {
    onUserAvatarChange(path) {
      this.user_avatar = path;
    },
    toggleSidebar() {
      this.toggleEnable = !this.toggleEnable;
    },
  },
};
</script>

<style lang="scss" scoped>
.side-bar-toggle {
  position: fixed;
  left: 205px;
  top: 50%;
  z-index: 1000;
  transition: ease 0.3s all;
}
.side-bar-toggle-enable {
  left: 0px !important;
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  transform: rotate(180deg);
}
.side-bar-toggle button {
  background: transparent;
  border: transparent;
  font-size: 17px;
  color: #ffde00;
}
.side-bar-toggle button:hover {
  color: #d5bf2d;
}
.heart {
  -webkit-transform: scale(1);
  -ms-transform: scale(1);
  -o-transform: scale(1);
  -moz-transform: scale(1);
  transform: scale(1);
  -webkit-transform-origin: center center;
  -moz-transform-origin: center center;
  -ms-transform-origin: center center;
  -o-transform-origin: center center;
  transition: all 1s;
}
.heart.css {
  -webkit-animation-delay: 0.5s;
  -moz-animation-delay: 0.5s;
  -ms-animation-delay: 0.5s;
  -o-animation-delay: 0.5s;
  animation-dely: 0.5s;
}
.heart.animated {
  -webkit-animation: 1600ms pulsate infinite alternate ease-in-out;
  -moz-animation: 1600ms pulsate infinite alternate ease-in-out;
  -ms-animation: 1600ms pulsate infinite alternate ease-in-out;
  -o-animation: 1600ms pulsate infinite alternate ease-in-out;
  animation: 1600ms pulsate infinite alternate ease-in-out;
}
.heart:before,
.heart:after {
  -moz-border-radius: 50px 50px 0 0;
  border-radius: 50px 50px 0 0;
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
  -webkit-transform-origin: 0 100%;
  -moz-transform-origin: 0 100%;
  -ms-transform-origin: 0 100%;
  -o-transform-origin: 0 100%;
  transform-origin: 0 100%;
}
.heart:after {
  left: 0;
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  -webkit-transform-origin: 100% 100%;
  -moz-transform-origin: 100% 100%;
  -ms-transform-origin: 100% 100%;
  -o-transform-origin: 100% 100%;
  transform-origin: 100% 100%;
}
.heart.css:hover {
  -webkit-transform: scale(1.5);
  -moz-transform: scale(1.5);
  -ms-transform: scale(1.5);
  -o-transform: scale(1.52);
  transform: scale(1.5);
  -webkit-animation: "";
  -moz-animation: none;
  -ms-animation: "";
  -o-animation: "";
  animation: "";
}
@keyframes pulsate {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.3);
  }
  100% {
    transform: scale(1);
  }
}
@-webkit-keyframes pulsate {
  0% {
    -webkit-transform: scale(1);
  }
  50% {
    -webkit-transform: scale(1.3);
  }
  100% {
    -webkit-transform: scale(1);
  }
}
@-moz-keyframes pulsate {
  0% {
    -moz-transform: scale(1);
  }
  50% {
    -moz-transform: scale(1.3);
  }
  100% {
    -moz-transform: scale(1);
  }
}
@-ms-keyframes pulsate {
  0% {
    -ms-transform: scale(1);
  }
  50% {
    -ms-transform: scale(1.3);
  }
  100% {
    -ms-transform: scale(1);
  }
}
@-o-keyframes pulsate {
  0% {
    -o-transform: scale(1);
  }
  50% {
    -o-transform: scale(1.3);
  }
  100% {
    -o-transform: scale(1);
  }
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

