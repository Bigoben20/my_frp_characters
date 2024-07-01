import{Q as D,k as l,T as V,f as n,a,u as _,w as m,F as b,o as r,Z as L,b as e,d as z,t as u,p as j,g as S,e as B,x as g}from"./app-FB9APauy.js";import{a as O}from"./AuthenticatedLayout-dxxM9yZx.js";import{_ as $}from"./Modal-2d6K5sDs.js";import{_ as T}from"./TextInput-AeVWHFo9.js";import{a as H,_ as U,M as E}from"./Roll-Af3tS56f.js";import"./ApplicationLogo-gxtVrTxw.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const I=e("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},"Dashboard",-1),K={class:"py-12"},Q={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},Z={class:"p-4 overflow-hidden bg-white shadow-sm sm:p-6 dark:bg-gray-800 sm:rounded-lg"},q={class:"mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100"},A={class:"text-blue-600 dark:text-blue-400"},G={class:"mb-2"},J={class:"w-full"},P={class:"w-full text-left table-fixed"},R=e("thead",{class:"dark:text-gray-300"},[e("tr",{class:"bg-gray-100 dark:bg-gray-700"},[e("th",{class:"px-3 py-1.5 rounded-l w-10"},"ID"),e("th",{class:"px-3 py-1.5"},"Name"),e("th",{class:"px-3 py-1.5 rounded-r"},"High Concept")])],-1),W={class:"dark:text-gray-100"},X=["onClick"],Y={class:"px-3 py-1.5"},ee={class:"px-3 py-1.5 whitespace-nowrap overflow-hidden text-ellipsis"},te={class:"px-3 py-1.5"},se={class:"overflow-hidden text-ellipsis whitespace-nowrap"},ae={class:"py-12"},oe={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},le={class:"p-4 bg-white shadow-sm sm:p-6 dark:bg-gray-800 sm:rounded-lg"},ne={class:"p-6"},re=e("h2",{class:"text-lg font-medium text-gray-900 dark:text-gray-100"}," Create Character ",-1),ie=e("i",{class:"text-sm fa-solid fa-x"},null,-1),de=[ie],ce={key:0,class:"flex w-full gap-1"},ue={class:"flex flex-col"},he=e("label",{for:"name",class:"dark:text-gray-200"},"Name:",-1),_e={class:"flex flex-col"},fe=e("label",{for:"high_concept",class:"dark:text-gray-200"},"High Concept:",-1),pe=["disabled"],me=e("span",null,"Create",-1),ge={key:0,class:"text-green-500 fa-solid fa-check-circle"},xe={class:"p-6"},ve={class:"relative mb-2"},ye=e("h2",{class:"text-lg font-medium text-gray-900 dark:text-gray-100"}," Karakteri Sil ",-1),be=e("i",{class:"text-sm fa-solid fa-x"},null,-1),ke=[be],we={class:"my-6 dark:text-gray-200"},Ce={class:"flex items-center justify-between"},Ve=e("span",null,"Vazgeç",-1),je=[Ve],Se=e("span",null,"Sil",-1),ze={__name:"Dashboard",props:{characters:{type:Object}},setup(k){D();const f=l(null),x=l(!1),p=l(!1),v=l(!1),i=l([]),h=l(!1),d=V({name:"",high_concept:""}),F=async()=>{g.start(),h.value=!0,i.value=[],d.post("/character-create",{preserveScroll:!0,onSuccess:o=>{C()},onError:o=>{let s=Object.keys(o);for(let t=0;t<s.length;t++)i.value.push(o[s[t]])},onFinish:()=>{h.value=!1,g.done()}})},w=V({id:""}),y=l(!1);l(!1);function M(o){g.start(),y.value=!0,w.id=o,w.post("/character-delete",{preserveScroll:!0,onSuccess:s=>{p.value=!1},onError:s=>{let t=Object.keys(s);for(let c=0;c<t.length;c++)i.value.push(s[t[c]])},onFinish:()=>{y.value=!1,g.done()}})}function C(){d.reset(),h.value=!1,i.value=[],v.value=!1,x.value=!1}function N(o){window.location.href="/character-detail/"+o}return(o,s)=>(r(),n(b,null,[a(_(L),{title:"Dashboard"}),a(O,null,{header:m(()=>[I]),default:m(()=>[e("div",K,[e("div",Q,[e("div",Z,[e("div",q,[z("Characters "),e("span",A,"("+u(k.characters.length)+")",1)]),e("div",G,[e("button",{type:"button",class:"px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect",onClick:s[0]||(s[0]=t=>x.value=!0)}," Create ")]),e("div",J,[e("table",P,[R,e("tbody",W,[(r(!0),n(b,null,j(k.characters,t=>(r(),n("tr",{key:t.id,onClick:c=>N(t.id),class:"hover:cursor-pointer hover:bg-gray-100/50 dark:hover:bg-gray-700/20"},[e("td",Y,u(t.id),1),e("td",ee,u(t.name),1),e("td",te,[e("div",se,u(t.high_concept),1)])],8,X))),128))])])])])])]),e("div",ae,[e("div",oe,[e("div",le,[a(H)])])])]),_:1}),a($,{show:x.value},{default:m(()=>[e("div",ne,[e("div",{class:"relative mb-2"},[re,e("button",{class:"absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect",onClick:C},de)]),i.value.length>0?(r(),n("div",ce,[(r(!0),n(b,null,j(i.value,(t,c)=>(r(),n("div",{key:c,class:"px-3 py-1 text-red-500 border border-red-300 rounded bg-red-50 full"},u(t),1))),128))])):S("",!0),e("form",{onSubmit:B(F,["prevent"]),class:"grid justify-between grid-cols-1 gap-5 mt-4 md:items-end"},[e("div",ue,[he,a(T,{id:"name",modelValue:_(d).name,"onUpdate:modelValue":s[1]||(s[1]=t=>_(d).name=t)},null,8,["modelValue"])]),e("div",_e,[fe,a(U,{rows:"2",id:"high_concept",modelValue:_(d).high_concept,"onUpdate:modelValue":s[2]||(s[2]=t=>_(d).high_concept=t)},null,8,["modelValue"])]),e("button",{class:"px-4 py-2 rounded bg-indigo-200 text-indigo-700 hoverEffect h-[42px] flex gap-1 items-center justify-center",type:"submit",disabled:h.value||v.value},[me,a(E,{show:h.value,radius:"4"},null,8,["show"]),v.value?(r(),n("i",ge)):S("",!0)],8,pe)],32)])]),_:1},8,["show"]),a($,{show:p.value},{default:m(()=>[e("div",xe,[e("div",ve,[ye,e("button",{class:"absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect",onClick:s[3]||(s[3]=t=>{f.value=null,p.value=!1})},ke)]),e("div",we,' "'+u(f.value.name)+'" karakterini silmek istediğinize emin misiniz? ',1),e("div",Ce,[e("button",{class:"px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect h-[42px] flex gap-1 items-center justify-center",onClick:s[4]||(s[4]=t=>{f.value=null,p.value=!1})},je),e("button",{class:"px-4 py-2 rounded bg-red-200 text-red-700 hoverEffect h-[42px] flex gap-1 items-center justify-center",onClick:s[5]||(s[5]=t=>M(f.value.id))},[Se,a(E,{show:y.value,radius:"4"},null,8,["show"])])])])]),_:1},8,["show"])],64))}};export{ze as default};