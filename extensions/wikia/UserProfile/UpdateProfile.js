function displaySection(id,country,section)
{
	country_id = -1;
	for(x=0;x<=countries.length-1;x++)
	{
		if (country==countries[x].country)
		{
			country_id=x
		}
	}

	section_select = "";
	if (countries[country_id])
	{
		$(id+"_label").innerHTML = countries[country_id].name
		section_select += "<select class='profile-form' name=" + id + " id=" + id + "><option></option>" 
		for(x=0;x<=countries[country_id].sections.length-1;x++)
		{
			section_select += "<option value=\"" + x + "\"" + ((x==section)?" selected":"") + ">" + countries[country_id].sections[x] + "</option>";
		}
		section_select += "</select>";
	}                  

	$(id+"_form").innerHTML = section_select
}
