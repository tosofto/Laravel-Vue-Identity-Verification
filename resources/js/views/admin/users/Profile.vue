<template>
  <div
    class="page-profile"
    :class="
      current_user_role == 'practitioner' || toggle == true
        ? 'role_practitioner'
        : 'main-content'
    "
  >
    <!-- :class="user_role == 'practitioner' ? 'role_practitioner' : 'main-content'" -->
    <div class="page-header">
      <h3 class="page-title">User Profile</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Users</a></li>
        <li class="breadcrumb-item active">
          {{ user_first_name }} {{ user_last_name }}
        </li>
      </ol>
    </div>
    <div
      v-if="current_user_verification_status == 'nonactivated'"
      class="row member-verification"
    >
      <button
        class="btn btn-warning btn-rounded"
        @click="startMemberVerification"
      >
        <div class="verification-icon">
          <i class="fa-solid fa-user-check"></i>
        </div>
        <span>Start Verification</span>
      </button>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <tabs class="tabs-default">
              <div class="row">
                <div class="col-sm-2">
                  <div class="avatar-container">
                    <img
                      :src="user_picture"
                      alt="Admin Avatar"
                      class="img-fluid"
                    />
                    <form
                      @submit="changeUserAvatar"
                      enctype="multipart/form-data"
                    >
                      <input
                        id="user-avatar"
                        type="file"
                        accept="image/png, image/gif, image/jpeg"
                        class="form-control"
                        v-on:change="onChange"
                        style="display: none"
                      />
                      <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        style="display: none"
                      ></button>
                      <button
                        @click="changeAvatarOccurr"
                        v-tooltip="{
                          content: tooltipText,
                          placement: position + '-center',
                          delay: {
                            show: 200,
                            hide: 300,
                          },
                          classes: ['info'],
                        }"
                        class="user-avatar-change"
                      ></button>
                    </form>
                  </div>
                  <div class="personal-info"></div>
                </div>
                <div class="col-sm-10">
                  <h2>Edit Profile</h2>
                  <div class="edit-personal-profile">
                    <b-form @submit.stop.prevent="onSubmit">
                      <div class="user-name-edit">
                        <b-form-group
                          id="first-name-input-group"
                          label="First Name"
                          label-for="first-name-input"
                        >
                          <b-form-input
                            id="first-name-input"
                            name="first-name-input"
                            v-model="user_first_name"
                            v-validate="{ required: true, min: 3 }"
                            :state="validateState('first-name-input')"
                            aria-describedby="first-name-input-live-feedback"
                            data-vv-as="Name"
                          ></b-form-input>

                          <b-form-invalid-feedback
                            id="first-name-input-live-feedback"
                            >{{
                              veeErrors.first("first-name-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>

                        <b-form-group
                          id="last-name-input-group"
                          label="Last Name"
                          label-for="last-name-input"
                        >
                          <b-form-input
                            id="last-name-input"
                            name="last-name-input"
                            v-model="user_last_name"
                            v-validate="{ required: true, min: 3 }"
                            :state="validateState('last-name-input')"
                            aria-describedby="last-name-input-live-feedback"
                            data-vv-as="Name"
                          ></b-form-input>

                          <b-form-invalid-feedback
                            id="last-name-input-live-feedback"
                            >{{
                              veeErrors.first("last-name-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>
                      </div>

                      <div class="email-edit">
                        <b-form-group
                          id="email-input-group"
                          label="Email"
                          label-for="email-input"
                        >
                          <b-form-input
                            id="email-input"
                            name="email-input"
                            v-model="user_email"
                            v-validate="{ required: true, min: 3 }"
                            :state="validateState('email-input')"
                            aria-describedby="email-input-live-feedback"
                            data-vv-as="Name"
                          ></b-form-input>

                          <b-form-invalid-feedback
                            id="email-input-live-feedback"
                            >{{
                              veeErrors.first("email-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>
                      </div>

                      <div class="user-gender-role-edit">
                        <b-form-group
                          id="gender-input-group"
                          label="Gender"
                          label-for="gender-input"
                        >
                          <b-form-select
                            id="gender-input"
                            name="gender-input"
                            v-model="user_gender"
                            v-validate="{ required: true }"
                            :state="validateState('gender-input')"
                            aria-describedby="gender-input-live-feedback"
                            data-vv-as="Gender"
                            :options="genders"
                          ></b-form-select>

                          <b-form-invalid-feedback
                            id="gender-input-live-feedback"
                            >{{
                              veeErrors.first("gender-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>

                        <b-form-group
                          id="role-input-group"
                          label="Role"
                          label-for="role-input"
                          :class="
                            current_user_role == 'practitioner'
                              ? 'visibility_hidden'
                              : 'visibility_show'
                          "
                        >
                          <b-form-select
                            id="role-input"
                            name="role-input"
                            v-model="user_role"
                            v-validate="{ required: true }"
                            :state="validateState('role-input')"
                            aria-describedby="role-input-live-feedback"
                            data-vv-as="Role"
                            :options="roles"
                          ></b-form-select>

                          <b-form-invalid-feedback
                            id="role-input-live-feedback"
                            >{{
                              veeErrors.first("role-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>
                      </div>

                      <div class="id-serial-edit">
                        <b-form-group
                          id="id-input-group"
                          label="ID Number"
                          label-for="id-input"
                        >
                          <b-form-input
                            id="id-input"
                            name="id-input"
                            v-model="user_id_number"
                            v-validate="{ required: true }"
                            :state="validateState('id-input')"
                            aria-describedby="id-input-live-feedback"
                            data-vv-as="ID Number"
                          ></b-form-input>

                          <b-form-invalid-feedback
                            id="id-input-live-feedback"
                            >{{
                              veeErrors.first("id-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>

                        <b-form-group
                          id="serial-input-group"
                          label="Serial Number"
                          label-for="serial-input"
                        >
                          <b-form-input
                            id="serial-input"
                            name="serial-input"
                            v-model="user_serial_number"
                            v-validate="{ required: true }"
                            :state="validateState('serial-input')"
                            aria-describedby="serial-input-live-feedback"
                            data-vv-as="Serial Number"
                          ></b-form-input>

                          <b-form-invalid-feedback
                            id="serial-input-live-feedback"
                            >{{
                              veeErrors.first("serial-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>
                      </div>

                      <div class="company-region-edit">
                        <b-form-group
                          id="company-input-group"
                          label="Company"
                          label-for="company-input"
                        >
                          <b-form-input
                            id="company-input"
                            name="company-input"
                            v-model="user_company"
                            v-validate="{ required: true }"
                            :state="validateState('company-input')"
                            aria-describedby="company-input-live-feedback"
                            data-vv-as="Company"
                          ></b-form-input>

                          <b-form-invalid-feedback
                            id="company-input-live-feedback"
                            >{{
                              veeErrors.first("company-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>

                        <b-form-group
                          id="region-input-group"
                          label="Region"
                          label-for="region-input"
                        >
                          <b-form-input
                            id="region-input"
                            name="region-input"
                            v-model="user_region"
                            v-validate="{ required: true }"
                            :state="validateState('region-input')"
                            aria-describedby="region-input-live-feedback"
                            data-vv-as="Region"
                          ></b-form-input>

                          <b-form-invalid-feedback
                            id="region-input-live-feedback"
                            >{{
                              veeErrors.first("region-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>
                      </div>

                      <div class="verification-health-edit">
                        <b-form-group
                          id="health-input-group"
                          label="Health Status"
                          label-for="health-input"
                        >
                          <b-form-select
                            id="health-input"
                            name="health-input"
                            v-model="user_health_status"
                            v-validate="{ required: true }"
                            :state="validateState('health-input')"
                            aria-describedby="health-input-live-feedback"
                            data-vv-as="Health Status"
                            :options="healthStatues"
                          ></b-form-select>

                          <b-form-invalid-feedback
                            id="health-input-live-feedback"
                            >{{
                              veeErrors.first("health-input")
                            }}</b-form-invalid-feedback
                          >
                        </b-form-group>
                      </div>

                      <div class="submit-reset">
                        <b-button class="user-info-submit" type="submit"
                          >Save</b-button
                        >
                      </div>
                    </b-form>
                  </div>
                  <h2 style="margin-top: 40px">Update Password</h2>
                  <div class="edit-personal-password">
                    <b-form @submit.stop.prevent="changePassword">
                      <b-form-group
                        id="current-password-input-group"
                        label="Current Password"
                        label-for="current-password-input"
                      >
                        <b-form-input
                          id="current-password-input"
                          name="current-password-input"
                          v-model="user_current_password"
                          v-validate="{ required: true }"
                          :state="validateState('current-password-input')"
                          aria-describedby="current-password-input-live-feedback"
                          data-vv-as="Current Password"
                          type="password"
                        ></b-form-input>

                        <b-form-invalid-feedback
                          id="current-password-input-live-feedback"
                          >{{
                            veeErrors.first("current-password-input")
                          }}</b-form-invalid-feedback
                        >
                      </b-form-group>

                      <b-form-group
                        id="new-password-input-group"
                        label="New Password"
                        label-for="new-password-input"
                      >
                        <b-form-input
                          id="new-password-input"
                          name="new-password-input"
                          v-model="user_new_password"
                          v-validate="{ required: true, min: 6 }"
                          :state="validateState('new-password-input')"
                          aria-describedby="new-password-input-live-feedback"
                          data-vv-as="New Password"
                          type="password"
                        ></b-form-input>

                        <b-form-invalid-feedback
                          id="new-password-input-live-feedback"
                          >{{
                            veeErrors.first("new-password-input")
                          }}</b-form-invalid-feedback
                        >
                      </b-form-group>

                      <b-form-group
                        id="confirm-password-input-group"
                        label="Confirm Password"
                        label-for="confirm-password-input"
                      >
                        <b-form-input
                          id="confirm-password-input"
                          name="confirm-password-input"
                          v-model="user_confirm_password"
                          v-validate="{ required: true }"
                          :state="validateState('confirm-password-input')"
                          aria-describedby="confirm-password-input-live-feedback"
                          data-vv-as="confirm-password"
                          type="password"
                        ></b-form-input>

                        <b-form-invalid-feedback
                          id="confirm-password-input-live-feedback"
                          >{{
                            veeErrors.first("confirm-password-input")
                          }}</b-form-invalid-feedback
                        >
                      </b-form-group>
                      <div class="submit-user-password-change">
                        <b-button class="user-info-submit" type="submit"
                          >Save</b-button
                        >
                      </div>
                    </b-form>
                  </div>
                </div>
              </div>
            </tabs>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Tabs, Tab } from "vue-tabs-component";
import Ls from "./../../../services/ls.js";
export default {
  props: ["toggle"],
  data() {
    return {
      user_id: "",
      user_first_name: "",
      user_last_name: "",
      user_email: "",
      user_gender: "",
      user_role: "practitioner",
      user_id_number: "",
      user_serial_number: "",
      user_company: "",
      user_region: "",
      user_picture: "/assets/img/default-user-avatar.jpg",
      user_health_status: "",
      user_validity_period: "",
      img: "",
      tooltipText: "Change your avatar",
      position: "bottom",
      genders: [
        { value: "male", text: "Male" },
        { value: "female", text: "Female" },
      ],
      roles: [
        { value: "practitioner", text: "Practitioner" },
        { value: "regional_admin", text: "Regional Admin" },
        { value: "admin", text: "System Admin" },
      ],
      verifications: [
        { value: "nonactivated", text: "Not Activated" },
        { value: "processing", text: "Processing" },
        { value: "activated", text: "Activated" },
      ],
      healthStatues: [
        { value: "bad", text: "Bad" },
        { value: "normal", text: "Normal" },
        { value: "good", text: "Good" },
      ],
      user_current_password: "......",
      user_new_password: "......",
      user_confirm_password: "......",
      current_user_role: "",
      current_user_verification_status: "",
    };
  },
  components: {
    tabs: Tabs,
    tab: Tab,
  },
  watch: {
    "$route.params.id": function (id) {
      this.fetchUserInfo(id);
    },
  },
  created() {
    this.user_id = this.$route.params.id;
    this.current_user_role = Ls.get("Role");
    this.user_picture = "/assets/img/default-user-avatar.jpg";
    this.fetchUserInfo(this.user_id);
  },
  methods: {
    onChange(e) {
      this.img = e.target.files[0];
      if (this.img !== "") {
        this.changeUserAvatar(e);
      }
    },
    async fetchUserInfo(id) {
      try {
        const response = await axios.get(`/api/admin/user/get/${id}`);
        this.user_first_name = response.data.user_info[0].first_name;
        this.user_last_name = response.data.user_info[0].last_name;
        this.user_email = response.data.user_info[0].email;
        this.user_gender = response.data.user_info[0].gender;
        this.user_role = response.data.user_info[0].role;
        this.user_id_number = response.data.user_info[0].id_number;
        this.user_serial_number = response.data.user_info[0].serial_number;
        this.user_company = response.data.user_info[0].company;
        this.user_region = response.data.user_info[0].region;
        if (response.data.user_avatar.length !== 0) {
          this.user_picture = response.data.user_avatar;
        }
        this.user_health_status = response.data.user_info[0].health_status;
        if (id == Ls.get("user_id")) {
          this.current_user_verification_status =
            response.data.user_info[0].verification_result;
          if (this.current_user_verification_status == "nonactivated") {
            window.toastr["info"]("Your Identity has not been verified...");
          } else if (this.current_user_verification_status == "processing") {
            window.toastr["info"](
              "Your Identity is on the processing of verification now..."
            );
          } else if (this.current_user_verification_status == "activated") {
            window.toastr["info"]("Your Identity has already been verified...");
          }
        }
        this.user_validity_period = response.data.user_info[0].validity_period;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    changeUserAvatar(e) {
      let exist = this;
      e.preventDefault();
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      let formData = new FormData();
      formData.append("user_img", this.img);
      formData.append("user_id", this.user_id);
      if (formData.getAll("user_img")[0] !== "") {
        for (const value of formData.values()) {
        }
        axios
          .post("/api/admin/user/changeUserAvatar", formData, config)
          .then(function (res) {
            if (Array.isArray(res.data) && res.data.length !== 0) {
              Ls.set("user_avatar", res.data[0].path);
              exist.setUserAvatar(res.data[0].path);
            } else {
              Ls.set("user_avatar", res.data.path);
              exist.setUserAvatar(res.data.path);
            }
            window.toastr["success"](
              "The user avatar has been changed!",
              "Success"
            );
          });
      }
      this.img = "";
    },
    changeAvatarOccurr() {
      document.getElementById("user-avatar").click();
    },
    setUserAvatar(path) {
      this.user_picture = path;
      if (
        this.current_user_role == "practitioner" ||
        this.user_id == Ls.get("user_id")
      ) {
        this.$emit("userAvatarChange", this.user_picture);
      }
    },
    validateState(ref) {
      if (
        this.veeFields[ref] &&
        (this.veeFields[ref].dirty || this.veeFields[ref].validated)
      ) {
        return !this.veeErrors.has(ref);
      }
      return null;
    },
    resetForm() {
      this.user_first_name = "";
      this.user_last_name = "";
      this.user_email = "";
      this.user_gender = "male";
      this.user_role = "practitioner";
      this.user_id_number = "...";
      this.user_serial_number = "...";
      this.user_company = "...";
      this.user_region = "...";
      this.user_health_status = "normal";

      this.$nextTick(() => {
        this.$validator.reset();
      });
    },
    onSubmit() {
      this.$validator.validateAll().then((result) => {
        if (!result) {
          return;
        }

        let formData = {
          first_name: this.user_first_name,
          last_name: this.user_last_name,
          email: this.user_email,
          role: this.user_role,
          gender: this.user_gender,
          id_number: this.user_id_number,
          serial_number: this.user_serial_number,
          company: this.user_company,
          region: this.user_region,
          health_status: this.user_health_status,
        };

        axios
          .post(`/api/admin/user/edit/${this.user_id}`, formData)
          .then(function (res) {
            Ls.set("First Name", res.data[0].first_name);
            Ls.set("Last Name", res.data[0].last_name);
            Ls.set("Email", res.data[0].email);
            Ls.set("Role", res.data[0].role);
            Ls.set("Gender", res.data[0].gender);
            window.toastr["success"](
              "Your personal information has been changed!",
              "Success"
            );
          });
      });
    },
    changePassword() {
      this.$validator.validateAll().then((result) => {
        if (!result) {
          return;
        }
        let formData = {
          current_password: this.user_current_password,
          new_password: this.user_new_password,
          confirm_password: this.user_confirm_password,
        };

        axios
          .post(`/api/admin/user/updatePassword/${this.user_id}`, formData)
          .then(function (res) {
            if (res.data == 1) {
              window.toastr["success"](
                "Your password has been changed successfully!",
                "Success"
              );
            } else if (res.data == 3) {
              window.toastr["error"](
                "Your current password is not correct",
                "Error"
              );
            } else if (res.data == 2) {
              window.toastr["error"](
                "Please confirm new password again",
                "Error"
              );
            }
          });
      });
    },
    startMemberVerification() {
      this.$router.push("/admin/users/verification/" + this.user_id);
    },
  },
};
</script>

<style scoped>
.page-profile {
  transition: ease 0.3s all;
}
.role_practitioner {
  padding: 90px 30px 10px 30px;
  min-height: calc(100% - 39px);
}
.avatar-container {
  width: 100%;
  position: relative;
  max-width: 330px;
  height: 225px;
}
.avatar-container .user-avatar-change {
  position: absolute;
  top: 0px;
  left: 0px;
  height: 100%;
  width: 100%;
  background-color: transparent;
  border-color: transparent;
}
.avatar-container img {
  width: 100%;
  height: 100%;
}
.user-name-edit,
.id-serial-edit,
.user-gender-role-edit,
.company-region-edit {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
}
.user-name-edit #first-name-input-group,
.user-name-edit #last-name-input-group,
.user-gender-role-edit #gender-input-group,
.user-gender-role-edit #role-input-group,
.id-serial-edit #id-input-group,
.id-serial-edit #serial-input-group,
.company-region-edit #region-input-group,
.company-region-edit #company-input-group {
  width: 48%;
}
.submit-reset {
  display: flex;
  align-items: center;
  justify-content: left;
  flex-direction: row;
  margin-top: 30px;
}
.user-info-submit {
  margin-right: 20px;
  background-color: #ffde00;
  border-color: #ffde00;
  color: #5c5959;
}
.user-info-reset {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
}
.edit-personal-profile,
.edit-personal-password {
  background-color: rgb(240 246 247);
  padding: 10px;
}
.visibility_hidden {
  visibility: hidden;
}
.visibility_show {
  visibility: visible;
}
.member-verification {
  justify-content: flex-end;
  padding-bottom: 20px;
  padding-right: 20px;
}
.member-verification button {
  background-color: #ffde00 !important;
  border-color: #ffde00 !important;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0px !important;
}
.member-verification button span {
  padding: 5px 15px 5px 10px;
}
.verification-icon {
  padding-left: 15px;
  padding-right: 10px;
  padding-top: 5px;
  padding-bottom: 5px;
  border-right: 1px solid;
}
.personal-info {
  margin-top: 30px;
  padding: 0px 5px;
}
</style>
