Accordion=Class.create();Accordion.prototype={initialize:function(c,a,b){this.container=$(c);this.checkAllow=b||false;this.disallowAccessToNextSections=false;this.sections=$$("#"+c+" .section");this.currentSection=false;var d=$$("#"+c+" .section "+a);d.each(function(e){Event.observe(e,"click",this.sectionClicked.bindAsEventListener(this));}.bind(this));},sectionClicked:function(a){this.openSection($(Event.element(a)).up(".section"));Event.stop(a);},openSection:function(d){var d=$(d);if(this.checkAllow&&!Element.hasClassName(d,"allow")){return;}if(d.id!=this.currentSection){this.closeExistingSection();this.currentSection=d.id;$(this.currentSection).addClassName("active");var c=Element.select(d,".a-item");c[0].show();if(this.disallowAccessToNextSections){var a=false;for(var b=0;b<this.sections.length;b++){if(a){Element.removeClassName(this.sections[b],"allow");}if(this.sections[b].id==d.id){a=true;}}}}},closeSection:function(b){$(b).removeClassName("active");var a=Element.select(b,".a-item");a[0].hide();},openNextSection:function(b){for(section in this.sections){var a=parseInt(section)+1;if(this.sections[section].id==this.currentSection&&this.sections[a]){if(b){Element.addClassName(this.sections[a],"allow");}this.openSection(this.sections[a]);return;}}},openPrevSection:function(b){for(section in this.sections){var a=parseInt(section)-1;if(this.sections[section].id==this.currentSection&&this.sections[a]){if(b){Element.addClassName(this.sections[a],"allow");}this.openSection(this.sections[a]);return;}}},closeExistingSection:function(){if(this.currentSection){this.closeSection(this.currentSection);}}};
