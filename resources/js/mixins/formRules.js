export default {
    name: 'form-rules',

    data(val) {
        return {
            requiredRules: [
                v => !!v || 'El camp és obligatori-'+val,
            ],
            requiredCheckRules: [
                v => !!v || 'Has de marcar la casella',
            ],
            cifRules: [
                v => !!v || 'El CIF és obligatori',
                v => /^([A-Z]|[0-9])[0-9]{7}([A-Z]|[0-9])$/i.test(v) || 'Has de posar un CIF vàlid'
            ],
            emailRules: [
                v => !!v || 'El e-mail és obligatori',
                v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,4})+$/.test(v) || 'Has de posar un e-mail vàlid'
            ],
            usernameRules: [
                v => !!v || 'El nom d\'usuari és obligatori',
                v => (v && v.length >= 6) || 'La mida mínima és de 6 caracters',
                v => (v && v.length <= 25) || 'La mida màxima és de 25 caracters',
                v => /^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/.test(v) || 'Només pot contrindre lletres, números, . i _',
            ],
            required5Rules: [
                v => !!v || 'El camp és obligatori',
                v => (v && v.length <= 5) || 'La mida ha de ser menor de 5 caracters'
            ],
            required10Rules: [
                v => !!v || 'El camp és obligatori',
                v => (v && v.length <= 10) || 'La mida ha de ser menor de 10 caracters'
            ],
            required25Rules: [
                v => !!v || 'El camp és obligatori',
                v => (v && v.length <= 25) || 'La mida ha de ser menor de 25 caracters'
            ],
            required50Rules: [
                v => !!v || 'El camp és obligatori',
                v => (v && v.length <= 50) || 'La mida ha de ser menor de 50 caracters'
            ],
            required80Rules: [
                v => !!v || 'El camp és obligatori',
                v => (v && v.length <= 50) || 'La mida ha de ser menor de 80 caracters'
            ],
            required100Rules: [
                v => !!v || 'El camp és obligatori',
                v => (v && v.length <= 100) || 'La mida ha de ser menor de 100 caracters'
            ],
        }
    },
}  