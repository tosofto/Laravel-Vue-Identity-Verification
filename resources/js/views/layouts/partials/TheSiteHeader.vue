<template>
  <header class="site-header">
    <a href="#" class="brand-main">
      <img
        id="logo-desk"
        src="/assets/img/logo.png"
        alt="Identity Verification Portal"
        class="d-none d-md-inline"
      />
      <img
        id="logo-mobile"
        src="/assets/img/logo.png"
        alt="Identity Verification Portal"
        class="d-md-none"
      />
      <span class="d-none d-md-inline title">Identity Verification Portal</span>
      <span class="d-md-none title">IVP</span>
    </a>
    <a href="#" class="nav-toggle" @click="onNavToggle">
      <div class="hamburger hamburger--arrowturn">
        <div class="hamburger-box">
          <div class="hamburger-inner" />
        </div>
      </div>
    </a>
    <ul class="action-list">
      <li v-if="user_role == 'admin' || user_role == 'sub_admin'">
        <v-dropdown :show-arrow="false">
          <a slot="activator" href="#">
            <i class="icon-fa icon-fa-plus" />
          </a>
          <v-dropdown-item>
            <a href="#"> <i class="icon-fa icon-fa-edit" /> New Post </a>
          </v-dropdown-item>
          <v-dropdown-item>
            <a href="#"> <i class="icon-fa icon-fa-tag" /> New Category </a>
          </v-dropdown-item>
          <v-dropdown-divider />
          <v-dropdown-item>
            <a href="#"> <i class="icon-fa icon-fa-star" /> Separated link </a>
          </v-dropdown-item>
        </v-dropdown>
      </li>
      <li v-if="user_role == 'admin' || user_role == 'sub_admin'">
        <v-dropdown :show-arrow="false">
          <a
            slot="activator"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="icon-fa icon-fa-bell" />
          </a>
          <div class="notification-dropdown">
            <h6 class="dropdown-header">Notifications</h6>
            <v-dropdown-item>
              <a class="dropdown-item" href="#">
                <i class="icon-fa icon-fa-user" /> New User was Registered
              </a>
            </v-dropdown-item>
            <v-dropdown-item>
              <a class="dropdown-item" href="#">
                <i class="icon-fa icon-fa-comment" /> A Comment has been posted.
              </a>
            </v-dropdown-item>
          </div>
        </v-dropdown>
      </li>
      <li>
        <v-dropdown :show-arrow="false" class="user-avatar">
          <a
            slot="activator"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            class="avatar"
          >
            <img :src="user_picture" alt="Avatar" />
          </a>
          <v-dropdown-item>
            <router-link
              class="dropdown-item"
              :to="'/admin/users/profile/' + user_id"
            >
              <i class="fa fa-user" aria-hidden="true"></i> Profile
            </router-link>
          </v-dropdown-item>
          <v-dropdown-item>
            <a href="#" class="dropdown-item" @click.prevent="logout">
              <i class="icon-fa icon-fa-sign-out" /> Logout
            </a>
          </v-dropdown-item>
        </v-dropdown>
      </li>
    </ul>
  </header>
</template>
<script type="text/babel">
import Auth from "../../../services/auth";
import Ls from "./../../../services/ls.js";
export default {
  props: ["user_avatar"],
  data() {
    return {
      user_role: "",
      user_id: "",
      user_picture: "/assets/img/default-user-avatar.jpg",
    };
  },
  watch: {
    user_avatar: function (newVal, oldVal) {
      this.user_picture = newVal;
    },
  },
  async created() {
    this.user_role = Ls.get("Role");
    this.user_id = Ls.get("user_id");
    this.user_picture = "/assets/img/default-user-avatar.jpg";
    try {
      const response = await axios.get(
        `/api/admin/user/avatar/get/${this.user_id}`
      );
      if (response.data.length !== 0) {
        Ls.set("user_avatar", response.data);
        this.user_picture = Ls.get("user_avatar");
      }
    } catch (err) {
      window.toastr["error"]("There was an error", "Error");
    }
  },
  methods: {
    onNavToggle() {
      this.$utils.toggleSidebar();
    },
    logout() {
      Auth.logout().then(() => {
        this.$router.replace("/login");
      });
    },
  },
};
</script>

<style scoped>
.action-list li {
  border-radius: 20px;
  background: transparent;
}
.action-list .dropdown-group {
  background-color: transparent;
}
.action-list .avatar img {
  width: 41px;
  border-radius: 20px;
}
.brand-main img {
  height: 40px;
  padding-top: 0px;
}
.title {
  font-size: 20px;
  font-family: "Roboto";
  color: #5c5959;
  font-weight: 500;
}
.user-avatar {
  height: 100%;
}
.user-avatar .avatar {
  height: 100%;
  border-radius: 20px;
}
.user-avatar .avatar img {
  max-height: 100%;
  height: 36px;
}
</style>

<style>
.user-avatar .dropdown-activator {
  height: 100% !important;
}
</style>