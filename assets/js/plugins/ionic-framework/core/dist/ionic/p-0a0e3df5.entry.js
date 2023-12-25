import{r as i,d as o,h as n,H as t,e as s}from"./p-5701584d.js";import{b as a,c as e}from"./p-22f1ceb4.js";import"./p-502e7dbf.js";import{c as r}from"./p-383feea1.js";import"./p-2c797579.js";import{B as p,d as l,e as d,f as c,g}from"./p-fb3c16cf.js";import{g as h}from"./p-2722d382.js";import{s as m}from"./p-e5037484.js";const f=i=>{const o=r(),n=r(),t=r();return n.addElement(i.querySelector("ion-backdrop")).fromTo("opacity",.01,"var(--backdrop-opacity)").beforeStyles({"pointer-events":"none"}).afterClearStyles(["pointer-events"]),t.addElement(i.querySelector(".loading-wrapper")).keyframes([{offset:0,opacity:.01,transform:"scale(1.1)"},{offset:1,opacity:1,transform:"scale(1)"}]),o.addElement(i).easing("ease-in-out").duration(200).addAnimation([n,t])},b=i=>{const o=r(),n=r(),t=r();return n.addElement(i.querySelector("ion-backdrop")).fromTo("opacity","var(--backdrop-opacity)",0),t.addElement(i.querySelector(".loading-wrapper")).keyframes([{offset:0,opacity:.99,transform:"scale(1)"},{offset:1,opacity:0,transform:"scale(0.9)"}]),o.addElement(i).easing("ease-in-out").duration(200).addAnimation([n,t])},u=i=>{const o=r(),n=r(),t=r();return n.addElement(i.querySelector("ion-backdrop")).fromTo("opacity",.01,"var(--backdrop-opacity)").beforeStyles({"pointer-events":"none"}).afterClearStyles(["pointer-events"]),t.addElement(i.querySelector(".loading-wrapper")).keyframes([{offset:0,opacity:.01,transform:"scale(1.1)"},{offset:1,opacity:1,transform:"scale(1)"}]),o.addElement(i).easing("ease-in-out").duration(200).addAnimation([n,t])},x=i=>{const o=r(),n=r(),t=r();return n.addElement(i.querySelector("ion-backdrop")).fromTo("opacity","var(--backdrop-opacity)",0),t.addElement(i.querySelector(".loading-wrapper")).keyframes([{offset:0,opacity:.99,transform:"scale(1)"},{offset:1,opacity:0,transform:"scale(0.9)"}]),o.addElement(i).easing("ease-in-out").duration(200).addAnimation([n,t])},k=class{constructor(n){i(this,n),this.presented=!1,this.keyboardClose=!0,this.duration=0,this.backdropDismiss=!1,this.showBackdrop=!0,this.translucent=!1,this.animated=!0,this.onBackdropTap=()=>{this.dismiss(void 0,p)},l(this.el),this.didPresent=o(this,"ionLoadingDidPresent",7),this.willPresent=o(this,"ionLoadingWillPresent",7),this.willDismiss=o(this,"ionLoadingWillDismiss",7),this.didDismiss=o(this,"ionLoadingDidDismiss",7)}componentWillLoad(){if(void 0===this.spinner){const i=a(this);this.spinner=e.get("loadingSpinner",e.get("spinner","ios"===i?"lines":"crescent"))}}async present(){await d(this,"loadingEnter",f,u,void 0),this.duration>0&&(this.durationTimeout=setTimeout(()=>this.dismiss(),this.duration+10))}dismiss(i,o){return this.durationTimeout&&clearTimeout(this.durationTimeout),c(this,i,o,"loadingLeave",b,x)}onDidDismiss(){return g(this.el,"ionLoadingDidDismiss")}onWillDismiss(){return g(this.el,"ionLoadingWillDismiss")}render(){const{message:i,spinner:o}=this,s=a(this);return n(t,{onIonBackdropTap:this.onBackdropTap,style:{zIndex:`${4e4+this.overlayIndex}`},class:Object.assign(Object.assign({},h(this.cssClass)),{[s]:!0,"loading-translucent":this.translucent})},n("ion-backdrop",{visible:this.showBackdrop,tappable:this.backdropDismiss}),n("div",{class:"loading-wrapper",role:"dialog"},o&&n("div",{class:"loading-spinner"},n("ion-spinner",{name:o})),i&&n("div",{class:"loading-content",innerHTML:m(i)})))}get el(){return s(this)}};k.style={ios:".sc-ion-loading-ios-h{--min-width:auto;--width:auto;--min-height:auto;--height:auto;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;left:0;right:0;top:0;bottom:0;display:-ms-flexbox;display:flex;position:fixed;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;font-family:var(--ion-font-family, inherit);contain:strict;-ms-touch-action:none;touch-action:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;z-index:1001}.overlay-hidden.sc-ion-loading-ios-h{display:none}.loading-wrapper.sc-ion-loading-ios{display:-ms-flexbox;display:flex;-ms-flex-align:inherit;align-items:inherit;-ms-flex-pack:inherit;justify-content:inherit;width:var(--width);min-width:var(--min-width);max-width:var(--max-width);height:var(--height);min-height:var(--min-height);max-height:var(--max-height);background:var(--background);opacity:0;z-index:10}.spinner-lines.sc-ion-loading-ios,.spinner-lines-small.sc-ion-loading-ios,.spinner-bubbles.sc-ion-loading-ios,.spinner-circles.sc-ion-loading-ios,.spinner-crescent.sc-ion-loading-ios,.spinner-dots.sc-ion-loading-ios{color:var(--spinner-color)}.sc-ion-loading-ios-h{--background:var(--ion-overlay-background-color, var(--ion-color-step-100, #f9f9f9));--max-width:270px;--max-height:90%;--spinner-color:var(--ion-color-step-600, #666666);--backdrop-opacity:var(--ion-backdrop-opacity, 0.3);color:var(--ion-text-color, #000);font-size:14px}.loading-wrapper.sc-ion-loading-ios{border-radius:8px;padding-left:34px;padding-right:34px;padding-top:24px;padding-bottom:24px}@supports ((-webkit-margin-start: 0) or (margin-inline-start: 0)) or (-webkit-margin-start: 0){.loading-wrapper.sc-ion-loading-ios{padding-left:unset;padding-right:unset;-webkit-padding-start:34px;padding-inline-start:34px;-webkit-padding-end:34px;padding-inline-end:34px}}@supports ((-webkit-backdrop-filter: blur(0)) or (backdrop-filter: blur(0))){.loading-translucent.sc-ion-loading-ios-h .loading-wrapper.sc-ion-loading-ios{background-color:rgba(var(--ion-background-color-rgb, 255, 255, 255), 0.8);-webkit-backdrop-filter:saturate(180%) blur(20px);backdrop-filter:saturate(180%) blur(20px)}}.loading-content.sc-ion-loading-ios{font-weight:bold}.loading-spinner.sc-ion-loading-ios+.loading-content.sc-ion-loading-ios{margin-left:16px}@supports ((-webkit-margin-start: 0) or (margin-inline-start: 0)) or (-webkit-margin-start: 0){.loading-spinner.sc-ion-loading-ios+.loading-content.sc-ion-loading-ios{margin-left:unset;-webkit-margin-start:16px;margin-inline-start:16px}}"};export{k as ion_loading}