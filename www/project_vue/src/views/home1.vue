<template>
    <main>

        <div class="p-4">

            <div class="pb-2">
                <!-- Button trigger modal -->
                <button id="btnTambahUserModal" type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Tambah Data</button>
                <div class="btn-group ms-3">
                    <select class="form-select" aria-label="Default select example" v-model="per_page"
                        @change="fetchData">
                        <option value="3">3</option>
                        <option value="6">6</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>

            <table class="table" style="color: black;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Name</th>
                        <th>NIK</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(mhs, index) in users" :key="index">
                        <th>{{ firstRowNumber + index }}</th>
                        <td>{{ mhs.id }}</td>
                        <td>{{ mhs.isActive ? 'Active' : 'Off' }}</td>
                        <td>{{ mhs.nama }}</td>
                        <td>{{ mhs.nik }}</td>
                        <td>{{ mhs.telp }}</td>
                        <td>{{ mhs.alamat }}</td>
                        <td>
                            <div class="d-inline-flex bd-highlight">
                                <div class="button btn-primary float-end mx-1">
                                    <button type="button" class="btn btn-secondary mx-1" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalEdit" @click="setData(mhs.id)">Edit</button>
                                </div>
                                <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal"
                                    @click="selectId(mhs.id)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>

                <!-- <tbody>
                    <tr>
                        <td colspan="6">Loading . . .</td>
                    </tr>
                </tbody> -->
            </table>

            <!-- Modal-Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: !prev_page_url }">
                        <button class="page-link" @click="fetchData(current_page - 1)"
                            :disabled="!prev_page_url">Previous</button>
                    </li>
                    <li class="page-item" v-for="page in last_page" :key="page"
                        :class="{ active: page === current_page }">
                        <button class="page-link" @click="fetchData(page)">{{ page }}</button>
                    </li>
                    <li class="page-item" :class="{ disabled: !next_page_url }">
                        <button class="page-link" @click="fetchData(current_page + 1)"
                            :disabled="!next_page_url">Next</button>
                    </li>
                </ul>
            </nav>

            <!-- ModalCreate -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Data</h1>
                            <button id="exampleModalBtnClose" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="storeNewData()">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Name</label>
                                    <input v-model="model.nama" type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="Masukkan Nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">NIK</label>
                                    <input v-model="model.nik" type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="Masukkan NIK" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Phone</label>
                                    <input v-model="model.telp" type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="Masukkan Nomor Ponsel" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Address</label>
                                    <textarea v-model="model.alamat" type="text" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Alamat" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Confirm -->
            <button id="btnOpenModalConfirmSaveUser" type="button" class="btn btn-primary" hidden data-bs-toggle="modal"
                data-bs-target="#confirmAddUserModal"></button>
            <div class="modal" ref="confirmAddUserModalRef" id="confirmAddUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-center">
                            <h5 class="modal-title">Konfirmasi Tambah User</h5>
                            <button id="confirmAddUserModalBtnClose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div><strong>Apakah data sudah sesuai?</strong></div>
                            Lajutkan untuk menyimpan user baru
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ModalDelete -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus</h1>
                            <button type="button" id="iniModalDelete" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="alert alert-danger" role="alert">Data Akan Terhapus!</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="button" class="btn btn-danger" @click="deleteUser()">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ModalEdit -->
            <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                            <button id="closeEditModal" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" v-if="userData != null">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nama</label>
                                <input v-model="userData.nama" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Masukkan Nama">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">NIK</label>
                                <input v-model="userData.nik" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Masukkan NIK">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Telepon</label>
                                <input v-model="userData.telp" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Masukkan Nomor Ponsel">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                <textarea v-model="userData.alamat" type="text" class="form-control"
                                    id="exampleInputEmail1" aria-describedby="emailHelp"
                                    placeholder="Masukkan Alamat"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" @click="editData()">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'

export default {

    name: 'user',

    data() {
        return {
            users: [],

            current_page: 1,
            last_page: 1,
            per_page: 7,
            prev_page_url: null,
            next_page_url: null,
            // firstRowNumber: 1,

            model: {
                nama: '',
                nik: '',
                telp: '',
                alamat: '',
            },
            deleteId: null,
            userData: null,
        };
    },

    async mounted() {
        await this.fetchData();
    },

    methods: {
        // Fungsi Promise
        waitForConfirmation: function () {
            return new Promise((resolve, reject) => {
                document.getElementById('btnOpenModalConfirmSaveUser').click();
                const modalConfirm = document.getElementById('confirmAddUserModal');
                const confirmBtn = modalConfirm.querySelector('.btn-primary');
                const rejectBtn = modalConfirm.querySelector('.btn-secondary');

                confirmBtn.addEventListener('click', () => {
                    confirmBtn.click();
                    resolve();
                });

                rejectBtn.addEventListener('click', () => {
                    document.getElementById('btnTambahUserModal').click();
                    rejectBtn.click();
                    reject();
                });
            });
        },


        selectId(userId) {
            this.deleteId = userId;
            this.userData = userId;

            this.comfrimDelete(this.deleteId);

            // console.log(this.userData);
        },

        resetUserdata() {
            this.userData = null;
        },

        async fetchData(page = this.current_page) {
            // document.getElementById('iniModalDelete').click();
            this.notifLoadData();

            try {
                const response = await axios.get(`http://localhost:8000/api/user?page=${page}&per_page=${this.per_page}`);
                if (response.data.status) {
                    console.log(response);
                    Swal.close();
                    this.users = response.data.data.data;
                    console.log(response.data.data.data);
                    this.current_page = response.data.data.current_page;
                    this.last_page = response.data.data.last_page;
                    this.prev_page_url = response.data.data.prev_page_url;
                    this.next_page_url = response.data.data.next_page_url;
                    this.firstRowNumber = (this.current_page - 1) * this.per_page + 1;
                } else {
                    Swal.close();
                    console.log('Failed to load data:', response.data.message);
                    Swal.fire('Error!', 'Failed to load data.', 'error');
                }
            } catch (error) {
                this.notifError();
                console.error('An error occurred:', error);
            }
        },

        notifDone() {
            Swal.fire({
                // position: "top-end",
                icon: "success",
                title: "Has been saved",
                showConfirmButton: false,
                // timer: 1500
            });
        },

        notifLoadData() {
            Swal.fire({
                title: "Loading Data . .",
                html: "I will close in <b></b> second.",
                // timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        },

        notifError() {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: '<a href="#">Why do I have this issue?</a>'
            });
        },

        storeNewData: async function () {
            await this.waitForConfirmation();
            document.getElementById('exampleModalBtnClose').click();
            this.notifDone();
            try {
                const req = await this.$axios({
                    method: 'post',
                    url: `${this.$root.APP_URL}/api/user`,
                    data: this.model,
                });

                await this.fetchData();

                for (let i in this.model) {
                    this.model[i] = '';
                }

            } catch (error) {
                Swal.close();
                this.notifError();

                for (let i in this.model) {
                    this.model[i] = '';
                }

                console.log(error);
            }
        },

        async setData(userId) {
            // console.log(userId);
            this.resetUserdata();
            this.notifLoadData();
            try {
                const response = await axios.get(`${this.$root.APP_URL}/api/user/${userId}`);
                this.userData = response.data.data;

                Swal.close();
                // console.log(this.userData);
            } catch (error) {
                this.notifError();
                console.error('Error fetching user data:', error);
            }
        },

        editData: async function () {

            try {
                this.notifLoadData();
                this.notifDone();
                const req = await this.$axios({
                    method: 'put',
                    url: `${this.$root.APP_URL}/api/user/${this.userData.id}`,
                    data: this.userData,
                });

                Swal.close();
                const resReq = req.data;
                // console.log(req);

                this.fetchData();
                document.getElementById('closeEditModal').click();


            } catch (error) {
                this.notifError();
                console.log(error);
            }
        },

        comfrimDelete(userId) {
            try {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.deleteUser(userId);
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            } catch (error) {
                this.notifError();
                console.log(error);
            }

        },

        deleteUser: async function () {

            try {
                const req = await this.$axios({
                    method: 'delete',
                    url: `${this.$root.APP_URL}/api/user/${this.deleteId}`,
                    data: this.model,

                })
                await this.fetchData();
            } catch (error) {
                this.notifError();
                console.log(error);
            }
        },

    }
};
</script>