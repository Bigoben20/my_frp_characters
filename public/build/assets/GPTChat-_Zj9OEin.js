import{Q as y,k as n,f as t,a as u,u as b,w as m,F as v,o as a,Z as k,b as e,t as _,g as h,i as p,p as w,s as D,q as B,B as C}from"./app-h0en9iyT.js";import{a as M}from"./AuthenticatedLayout-rsXAv3vl.js";import"./toast-5ndLv_OK.js";import{_ as N,M as S}from"./MiniLoader-RMwp9HnS.js";/* empty css                                                             */import"./ApplicationLogo-tQu6pJcW.js";import"./_plugin-vue_export-helper-x3n3nnut.js";const G=e("h2",{class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},"DND GPT",-1),P={class:"py-4 sm:py-12"},T={class:"mx-auto max-w-7xl"},V={class:"p-4 sm:rounded-lg md:p-8 dark:bg-gray-800"},j=e("div",{class:"mb-4 header"}," Sohbet Başlat ",-1),L={class:"flex flex-col gap-4 pb-4"},z={key:0,class:"-mb-3 text-xs text-red-500"},E={class:"flex flex-col items-stretch"},F=["disabled"],I=["disabled"],$=e("span",null," Gönder ",-1),q={class:"fa-regular fa-paper-plane"},A={class:"space-x"},H=e("span",null," Kalan Hakkınız: ",-1),K={class:"font-semibold text-amber-600"},Q=e("span",{class:"text-semibold"}," / 10",-1),U={key:0,class:"px-2 border-t border-gray-400"},Z={key:0,class:"flex justify-end w-full"},J={class:"flex flex-col items-end"},O=e("div",{class:"dark:text-gray-300"}," Siz: ",-1),R={class:"max-w-4xl px-3 py-2 bg-stone-200 dark:bg-opacity-85 rounded-[0.75rem_0.75rem_0px_0.75rem]"},W={key:1,class:"flex flex-col mt-4"},X=e("div",{class:"dark:text-gray-300"}," D&D GPT: ",-1),Y={class:"max-w-4xl px-3 py-2 bg-indigo-100 dark:bg-indigo-200/90 rounded-[0.75rem_0.75rem_0.75rem_0px]"},ie={__name:"GPTChat",setup(ee){y();const d=n("");n("");const s=n([]),g=n(.7),i=n(!1),c=n(""),x=async()=>{s.value.push({role:"user",content:d.value}),c.value="",d.value="",i.value=!0,await C.post("/send-dnd-gpt",{message:s.value,creativeness:g.value}).then(l=>{console.log(l.data);const r=l.data;r.success||(c.value=r.data.error),s.value.push(l.data.data.choices[0].message)}).catch(l=>{console.error("API çağrısında hata oluştu:",l)}).finally(()=>{i.value=!1})};return(l,r)=>(a(),t(v,null,[u(b(k),{title:"DND Chat"}),u(M,null,{header:m(()=>[G]),default:m(()=>[e("div",P,[e("div",T,[e("div",V,[j,e("div",null,[e("div",L,[c.value.length>0?(a(),t("div",z,_(c.value),1)):h("",!0),e("div",E,[p(e("textarea",{class:"generalInput",maxlength:"300","onUpdate:modelValue":r[0]||(r[0]=o=>d.value=o),placeholder:"Sorun nedir?",disabled:s.value.length>=20},null,8,F),[[w,d.value]]),u(N,{maxlength:"300",value:d.value.length},null,8,["value"])]),s.value.length<20?(a(),t("button",{key:1,type:"button",onClick:x,class:"flex items-center justify-center gap-1 px-4 py-2 text-indigo-700 bg-indigo-200 rounded hoverEffect",disabled:i.value},[$,p(e("i",q,null,512),[[D,!i.value]]),u(S,{show:i.value,radius:"4"},null,8,["show"])],8,I)):h("",!0),e("div",A,[H,e("span",K,_(10-s.value.length/2),1),Q])]),s.value.length>0?(a(),t("div",U,[(a(!0),t(v,null,B(s.value,(o,f)=>(a(),t(v,{key:f},[o.role=="user"?(a(),t("div",Z,[e("div",J,[O,e("div",R,_(o.content),1)])])):o.role=="assistant"?(a(),t("div",W,[X,e("div",Y,_(o.content),1)])):h("",!0)],64))),128))])):h("",!0)])])])])]),_:1})],64))}};export{ie as default};
