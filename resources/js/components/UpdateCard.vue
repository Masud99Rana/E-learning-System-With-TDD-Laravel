<template>
    <div>
        <button class="btn btn-success" @click="update">Update card details</button>
    </div>
</template>

<script>
import Swal from 'sweetalert';
import Axios from 'axios'
export default {
    props: ['email'],
    mounted() {
        this.handler = StripeCheckout.configure({
            key: 'pk_test_2QxtXr3vmiH6DhE7y0sFqGvE0015tRZth9',
            image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
            locale: 'auto',
            allowRememberMe: false,
            token(token) {
                Swal({ text: 'Please wait while we update your card details ...', buttons: false });
                Axios.post('/card/update', {
                    stripeToken: token.id
                }).then(resp => {
                    Swal({ text: 'Successfully updated card details', icon: 'success' })
                        .then(() => {
                            window.location = '';
                        });
                })
            }
        }) 
    },
    data() {
        return {
            handler: null
        }
    },
    methods: {
        update() {

            this.handler.open({
                name: 'MR Casts',
                description: 'MR Casts Subscription',
                email: this.email,
                panelLabel: 'Update card details'
            })
        }
    }
}
</script>
