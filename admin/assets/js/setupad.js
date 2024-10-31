jQuery(document).ready(function () {

	//  My Ads section ad list visibility START

	let tableCheckboxes = document.querySelector('#the-list input');
	if (tableCheckboxes) {
		document.querySelectorAll('#the-list input').forEach(element => element.addEventListener('click', event => {
			if (event.target.checked) {
				document.querySelector('.bi-dash').style.display = "block";

				let allInputsChecked = false;
				document.querySelectorAll('#the-list input').forEach(element => {
					if (!allInputsChecked && !element.checked) {
						allInputsChecked = true;
					}
				})
				if (!allInputsChecked) {
					document.querySelector('.bi-dash').style.display = "none";
				}
			} else {
				let allInputsUnchecked = true;
				document.querySelectorAll('#the-list input').forEach(element => {
					if (element.checked && allInputsUnchecked) {
						allInputsUnchecked = false;
					}
				})
				if (allInputsUnchecked) {
					document.querySelector('.bi-dash').style.display = "none";
				} else {
					document.querySelector('.bi-dash').style.display = "block";
				}
			}
		}))

		document.querySelector('#custom-select-all').addEventListener('click', event => {
			let allInputsUnchecked = true;
			document.querySelectorAll('#the-list input').forEach(element => {
				if (element.checked && allInputsUnchecked) {
					allInputsUnchecked = false;
				}
			})

			if (allInputsUnchecked) {
				document.querySelectorAll('#the-list input').forEach(element => {
					element.checked = true;
				})

			} else {
				document.querySelectorAll('#the-list input').forEach(element => {
					element.checked = false;
				})
				document.querySelector('.bi-dash').style.display = "none";
				event.target.checked = false;
			}
		})
	}

	//  My Ads section ad list visibility END

	// Single or Multiselect dropdown functionality START

	if (document.querySelector('.single-dropdown') || document.querySelector('.multiselect-dropdown')) {
		function MultiselectDropdown(options){
			var config={
				search:true,
				placeholder:'Select category',
				txtSelected:'Categories selected',
				txtAll:'All',
				txtRemove: 'Remove',
				txtSearch:'search',
				...options
			};
			function newEl(tag,attrs){
				var e=document.createElement(tag);
				if(attrs!==undefined) Object.keys(attrs).forEach(k=>{
					if(k==='class') { Array.isArray(attrs[k]) ? attrs[k].forEach(o=>o!==''?e.classList.add(o):0) : (attrs[k]!==''?e.classList.add(attrs[k]):0)}
					else if(k==='style'){
						Object.keys(attrs[k]).forEach(ks=>{
							e.style[ks]=attrs[k][ks];
						});
					}
					else if(k==='text'){attrs[k]===''?e.innerHTML='&nbsp;':e.innerText=attrs[k]}
					else e[k]=attrs[k];
				});
				return e;
			}

			document.querySelectorAll("select[multiple]").forEach((el,k)=>{

				function findMultiselectDropdown(select) {
					var sibling = select.nextElementSibling;
					while (sibling) {
						if (sibling.classList.contains('multiselect-dropdown')) {
							return sibling;
						}
						sibling = sibling.nextElementSibling;
					}
					return null;
				}

				var div = findMultiselectDropdown(el); // Find the corresponding .multiselect-dropdown element
				if (!div) return; // Skip if no appropriate sibling found

				el.style.display='none';
				el.parentNode.insertBefore(div,el.nextSibling);
				var listWrap=newEl('div',{class:'multiselect-dropdown-list-wrapper'});
				var list=newEl('div',{class:'multiselect-dropdown-list'});
				var search=newEl('input',{class:['multiselect-dropdown-search'].concat([config.searchInput?.class??'form-control']),style:{width:'100%',display:el.attributes['multiselect-search']?.value==='true'?'block':'none'},placeholder:config.txtSearch});
				listWrap.appendChild(search);
				div.appendChild(listWrap);
				listWrap.appendChild(list);

				el.loadOptions=()=>{
					list.innerHTML='';

					if(el.attributes['multiselect-select-all']?.value=='true'){
						var op=newEl('div',{class:'multiselect-dropdown-all-selector'})
						var ic=newEl('input',{type:'checkbox'});
						op.appendChild(ic);
						op.appendChild(newEl('label',{text:config.txtAll}));
						op.addEventListener('click',()=>{
							op.classList.toggle('checked');
							op.querySelector("input").checked=!op.querySelector("input").checked;

							var ch=op.querySelector("input").checked;
							list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")
								.forEach(i=>{if(i.style.display!=='none'){i.querySelector("input").checked=ch; i.optEl.selected=ch}});

							el.dispatchEvent(new Event('change'));
						});
						ic.addEventListener('click',(ev)=>{
							ic.checked=!ic.checked;
						});
						el.addEventListener('change', (ev)=>{
							let itms=Array.from(list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")).filter(e=>e.style.display!=='none');
							let existsNotSelected=itms.find(i=>!i.querySelector("input").checked);
							if(ic.checked && existsNotSelected) ic.checked=false;
							else if(ic.checked==false && existsNotSelected===undefined) ic.checked=true;
						});

						list.appendChild(op);
					}

					Array.from(el.options).map(o=>{
						var op=newEl('div',{class:o.selected?'checked':'',optEl:o})
						var ic=newEl('input',{type:'checkbox',checked:o.selected});
						op.appendChild(newEl('label',{text:o.text}));
						op.appendChild(ic);
						op.addEventListener('click',()=>{
							op.classList.toggle('checked');
							op.querySelector("input").checked=!op.querySelector("input").checked;
							op.optEl.selected=!!!op.optEl.selected;
							el.dispatchEvent(new Event('change'));
						});
						ic.addEventListener('click',(ev)=>{
							ic.checked=!ic.checked;
						});
						o.listitemEl=op;
						list.appendChild(op);
					});
					div.listEl=listWrap;

					div.refresh=()=>{
						div.querySelectorAll('span.optext, span.placeholder').forEach(t=>div.removeChild(t));
						var sels=Array.from(el.selectedOptions);
						if(sels.length>(el.attributes['multiselect-max-items']?.value??5)){
							div.appendChild(newEl('span',{class:['optext','maxselected'],text:sels.length+' '+config.txtSelected}));
						}
						else{
							sels.map(x=>{
								var c=newEl('span',{class:'optext',text:x.text, srcOption: x});
								if((el.attributes['multiselect-hide-x']?.value !== 'true'))
									c.appendChild(newEl('span',{class:'optdel',text:'🗙',title:config.txtRemove, onclick:(ev)=>{c.srcOption.listitemEl.dispatchEvent(new Event('click'));div.refresh();ev.stopPropagation();}}));

								div.appendChild(c);
							});
						}
						if(0==el.selectedOptions.length) div.appendChild(newEl('span',{class:'placeholder',text:el.attributes['placeholder']?.value??config.placeholder}));
					};
					div.refresh();
				}
				el.loadOptions();

				search.addEventListener('input',()=>{
					list.querySelectorAll(":scope div:not(.multiselect-dropdown-all-selector)").forEach(d=>{
						var txt=d.querySelector("label").innerText.toUpperCase();
						d.style.display=txt.includes(search.value.toUpperCase())?'flex':'none';
					});
				});

				div.addEventListener('click',()=>{
					div.listEl.style.display='block';
					search.focus();
					search.select();
				});

				document.addEventListener('click', function(event) {
					if (!div.contains(event.target)) {
						listWrap.style.display='none';
						div.refresh();
					}
				});
			});

			document.querySelectorAll("div[single]").forEach((el,k)=>{

				let div = el;
				let listWrap=div.querySelector('.single-dropdown-list-wrapper');

				el.loadOptions=()=>{
					el.querySelectorAll('.single-d-div').forEach(element => {
						element.addEventListener('click',()=>{
							el.querySelectorAll('.single-d-div').forEach(elem => elem.classList.remove('checked'));
							element.classList.toggle('checked');
							element.querySelector("input").checked=!element.querySelector("input").checked;
							element.querySelector("input").checked=true;
							listWrap.style.display='none';
							el.dispatchEvent(new Event('change'));
							element.dispatchEvent(new Event('change'));
						});
					})

					div.listEl=listWrap;

					div.refresh=()=>{
						el.querySelectorAll('.single-d-input').forEach(element => {
							if (element.checked) {
								el.querySelector('.optext').innerHTML = element.previousElementSibling.innerHTML;
							}
						});
					};
					div.refresh();
				}
				el.loadOptions();

				div.addEventListener('click',()=>{
					div.listEl.style.display='block';
				});

				document.addEventListener('click', function(event) {
					if (div != event.target) {
						listWrap.style.display='none';
						div.refresh();
					}
				});
			});
		}

		MultiselectDropdown(window.MultiselectDropdownOptions);
	}

	// Single or Multiselect dropdown functionality END

});
