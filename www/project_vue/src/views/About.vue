<!-- <template>
    <div class="p-5">
        <h2>About US</h2>
        <text>
            "Kami adalah tim yang bersemangat di bidang teknologi, terdiri dari pengembang perangkat lunak, desainer, dan profesional IT lainnya. Dengan dedikasi kami terhadap inovasi dan keunggulan, kami bertekad untuk menyediakan solusi teknologi terbaik bagi pelanggan kami. Melalui kolaborasi yang erat dan pemahaman mendalam tentang kebutuhan bisnis, kami berusaha memberikan solusi yang relevan dan berdaya guna. Kami komitmen untuk memberikan layanan yang berkualitas, menghadirkan produk-produk berkualitas tinggi, dan menjaga hubungan jangka panjang dengan pelanggan kami. Bersama-sama, kami membangun masa depan yang lebih cerah melalui teknologi."
        </text>
    </div>
</template>

<script>
export default {
        
    }
</script> -->
<template>
    <button @click="showAlert">Hello world</button>
</template>

<script>

export default {
    methods: {
        showAlert() {
            // Use sweetalert2
            this.$swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result)=>{
                if (result.isConfirmed){
                    this.$swal("SweetAlert2 is working!");
                }
            });
        },
    },
};
</script>