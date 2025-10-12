import { TransactionService } from '@/services/transaction'
import { Transaction } from '@/types/index'
import { defineStore } from 'pinia'

export const useTransactionStore = defineStore('transaction',{
    state: () => ({
        transactions: [] as Transaction[],
        total: '' as string,
        loading: false,
        headers:[
            { title:'ID', value:'id', align:""},
            { title:'User', value:'user.name', align:""},
            { title:'Type', value:'type', align:""},
            { title:'Price-IRR', value:'price', align:""},
            { title:'Fee', value:'fee', align:""},
            { title:'Weight', value:'weight', align:""},
            { title:'Total-IRR', value:'total', align:""},
            { title:'Created Date', value:'created_at', align:""},
        ],
        gold_price: [] as any
    }),
    getters: {},
    actions: {

        // allTransactions
        async allTranaction() {
            this.loading = true
            try {
                const { data } = await TransactionService.fetchTransactions()
                if (data) {
                    this.transactions = data
                    return data
                }
            } catch (error) {
                return error
            }
            finally{
                this.loading = false
            }
        },

        // gold price
        async goldPrice () {
            try {
                const { data } = await TransactionService.fetchGoldPrice()
                if (data) this.gold_price = data
                setTimeout(async() => {
                    await this.goldPrice()
                }, 60000);
            } catch (error) {
                return error
            }
        },

        // new transaction
        async storeTransaction (payload: any) {
            try {
                await TransactionService.createTransaction(payload)

                await this.allTranaction()
            } catch (error) {
                return error
            }
        }
    }
})