import { ref, inject } from "vue";
import axios from "axios";

export default function useFormatter() {
    const formatNumber = (value) => {
        if (!value) {
            return value;
        }

        return new Intl.NumberFormat("id-ID").format(value);
    };

    const formatDateTime = (value) => {
        const date = new Date(value);

        const options = {
            year: "numeric",
            month: "long",
            day: "numeric",
            // hour: "numeric",
            // minute: "numeric",
        };

        return date.toLocaleString("id-ID", options);
    };

    const convertNewlines = (text) => {
        if (text) {
            const items = text
                .split("\n")
                .map((item) => `<li>${item}</li>`)
                .join("");

            return items;
        }
    };

    return {
        formatNumber,
        formatDateTime,
        convertNewlines,
    };
}
