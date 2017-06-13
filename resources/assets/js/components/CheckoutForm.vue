<template>
    <div class="product">
        <h3>{{product.name}}</h3>
        <form action="/purchase" method="POST">
            <input type="hidden" name="stripeToken" v-model="stripeToken">
            <input type="hidden" name="stripeEmail" v-model="stripeEmail">
            <button @click.prevent="buy">Buy</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stripeEmail: '',
                stripeToken: ''
            }
        },
        methods: {
            buy() {
                this.stripe.open({
                    name: this.product.name,
                    description: this.product.description,
                    zipCode: true,
                    amount: this.product.price

                })
            }
        },
        props: [
            'product'
        ],
        created() {
            this.stripe = StripeCheckout.configure({
                key: Beestream.stripeKey,
                image: "/img/monogram.png",
                locale: "auto",
                token: (token) => {
                    this.stripeToken = token.id;
                    this.stripeEmail = token.email;
                    axios.post('/purchases', this.$data)
                        .then(response => console.log( response ))
                        .catch(error => {
                            console.log( error );
                        });
                }
            });
        }
    }
</script>
