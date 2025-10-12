import { useApi } from "@/composables/useApi";
import { Transaction } from "@/types";

export const TransactionService = {

    // fetch transactions
    async fetchTransactions () {
        return await useApi<Transaction>('buy-sell',{
            method: "GET"
        })
    },

    // fetch gold price
    async fetchGoldPrice () {
        return await useApi<any>('gold-price', {
            method: "GET"
        })
    },

    // new transaction
    async createTransaction(payload: any){
        return await useApi<any>('buy-sell',{
            method: "POST",
            body: payload
        })
    }
}