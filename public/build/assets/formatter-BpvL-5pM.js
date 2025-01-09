function m(){return{formatNumber:t=>t&&new Intl.NumberFormat("id-ID").format(t),formatDateTime:t=>{const n=new Date(t),e={year:"numeric",month:"long",day:"numeric"};return n.toLocaleString("id-ID",e)},convertNewlines:t=>{if(t)return t.split(`
`).map(e=>`<li>${e}</li>`).join("")}}}export{m as u};
