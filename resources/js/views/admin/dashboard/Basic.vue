<template>
  <div
    id="dashboardPage"
    :class="
      user_role == 'practitioner' || toggle == true
        ? 'role_practitioner'
        : 'main-content'
    "
  >
    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <!-- <i class="icon-fa icon-fa-envelope text-primary" /> -->
          <i class="fa fa-users text-primary" aria-hidden="true"></i>
          <span class="title"> {{ allUsers }} </span>
          <span class="desc"> All Users </span>
        </a>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <div class="system_admin">
            <div>
              <img src="/assets/img/admin.png" alt="System Admin" />
            </div>
            <span class="title"> {{ system_admin }} </span>
          </div>
          <span class="desc"> System Admins </span>
        </a>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <!-- <i class="icon-fa icon-fa-shopping-cart text-danger" /> -->
          <div class="system_admin">
            <div>
              <img src="/assets/img/sub_admin.png" alt="System Admin" />
            </div>
            <span class="title"> {{ regional_admin }} </span>
          </div>
          <span class="desc"> Regional Admins </span>
        </a>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <i class="fa fa-user text-info" aria-hidden="true"></i>
          <span class="title"> {{ practitioners }} </span>
          <span class="desc"> Practitioners </span>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header">
            <h6>
              <i class="icon-fa icon-fa-line-chart text-warning" />Traffic Stats
            </h6>
          </div>
          <div class="card-body">
            <line-graph
              :labels="['Jan', 'Feb', 'Mar', 'June']"
              :values="[20, 30, 40, 60]"
            />
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header">
            <h6>
              <i class="icon-fa icon-fa-bar-chart text-success" />Sales Chart
            </h6>
          </div>
          <div class="card-body">
            <bar-graph
              :labels="['Jan', 'Feb', 'Mar', 'June']"
              :values="[20, 30, 40, 60]"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-xl-12 mt-2">
        <div class="card">
          <div class="card-header">
            <h6 class="system-admins">
              <div><img src="/assets/img/admin.png" alt="System Admin" /></div>
              System Admins
            </h6>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Gender</th>
                  <th>Verification Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="admin in allAdmins" :key="admin.id">
                  <td>{{ admin.first_name }} {{ admin.last_name }}</td>
                  <td>{{ admin.gender }}</td>
                  <td>{{ admin.verification_result }}</td>
                  <td>
                    <a
                      :href="'/admin/users/profile/' + admin.id"
                      class="btn btn-default btn-xs"
                      >View</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-xl-12 mt-2">
        <div class="card">
          <div class="card-header">
            <h6 class="regional-admins">
              <div>
                <img src="/assets/img/sub_admin.png" alt="System Admin" />
              </div>
              Regional Admins
            </h6>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Gender</th>
                  <th>Verification Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="region in allRegionalAdmins" :key="region.id">
                  <td>{{ region.first_name }} {{ region.last_name }}</td>
                  <td>{{ region.gender }}</td>
                  <td>{{ region.verification_result }}</td>
                  <td>
                    <a
                      :href="'/admin/users/profile/' + region.id"
                      class="btn btn-default btn-xs"
                      >View</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-xl-12 mt-2">
        <div class="card">
          <div class="card-header">
            <h6 class="practitioners">
              <i
                class="fa fa-user"
                aria-hidden="true"
                style="color: #333333"
              ></i>
              Practitioners
            </h6>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Gender</th>
                  <th>Verification Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="practitioner in allPractitioners"
                  :key="practitioner.id"
                >
                  <td>
                    {{ practitioner.first_name }} {{ practitioner.last_name }}
                  </td>
                  <td>{{ practitioner.gender }}</td>
                  <td>{{ practitioner.verification_result }}</td>
                  <td>
                    <a
                      :href="'/admin/users/profile/' + practitioner.id"
                      class="btn btn-default btn-xs"
                      >View</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import LineGraph from "../../../components/chartjs/LineChart.vue";
import BarGraph from "../../../components/chartjs/BarChart.vue";
import PieGraph from "../../../components/chartjs/PieChart.vue";
import Ls from "./../../../services/ls.js";
export default {
  props: ["toggle"],
  components: {
    LineGraph,
    BarGraph,
    PieGraph,
  },
  data() {
    return {
      header: "header",
      user_role: "",
      allUsers: 0,
      system_admin: 0,
      regional_admin: 0,
      practitioners: 0,
      allAdmins: [],
      allRegionalAdmins: [],
      allPractitioners: [],
    };
  },
  async created() {
    this.user_role = Ls.get("Role");
    const response = await axios.get("/api/admin/users/get/allAdminUsers");
    let all_users = response.data;
    this.allUsers = all_users.length;
    console.log("Response System => ", this.allUsers, all_users);
    all_users.forEach((user, index) => {
      if (user.role == "admin") {
        this.allAdmins.push(user);
      } else if (user.role == "regional_admin") {
        this.allRegionalAdmins.push(user);
      } else if (user.role == "practitioner") {
        this.allPractitioners.push(user);
      }
    });
    this.system_admin = this.allAdmins.length;
    this.regional_admin = this.allRegionalAdmins.length;
    this.practitioners = this.allPractitioners.length;
  },
};
</script>
<style scoped>
#dashboardPage {
  transition: ease 0.3s all;
}
.role_practitioner {
  padding: 90px 30px 10px 30px;
  min-height: calc(100% - 39px);
}
.system_admin {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 37px;
}
.system_admin img {
  max-width: 100%;
}
.system_admin div {
  width: 35px;
}
.dashbox i {
  font-size: 30px;
  left: 40px;
  position: absolute;
  top: 45px;
}
.system-admins,
.regional-admins,
.practitioners {
  display: flex;
  align-items: center;
  justify-content: center;
}
.system-admins div,
.regional-admins div {
  width: 23px;
  height: 23px;
  margin-right: 10px;
}
.system-admins div img,
.regional-admins div img {
  max-width: 100%;
  position: relative;
  top: 1px;
}
</style>
