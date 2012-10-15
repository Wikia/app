/*****************************************************************************
 * 
 * mapniktile.cc - Generates maptiles for the WikiMiniAtlas
 *
 * (c) 2007 by Daniel Schwen (dschwen)
 *
 * This file is based on an example for Mapnik (c++ mapping toolkit)
 * Copyright (C) 2006 Artem Pavlenko
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *****************************************************************************/
// $Id$

#include <mapnik/map.hpp>
#include <mapnik/datasource_cache.hpp>
#include <mapnik/font_engine_freetype.hpp>
#include <mapnik/agg_renderer.hpp>
#include <mapnik/filter_factory.hpp>
#include <mapnik/color_factory.hpp>
#include <mapnik/image_util.hpp>

#include <iostream>

using namespace mapnik;

int main ( int argc , char** argv)
{    
    std::cout << argc << "\n";
    int zoom = 0;
    if( argc == 5 ) zoom = atoi(argv[1]);

    datasource_cache::instance()->register_datasources("/usr/lib/mapnik/input"); 
    freetype_engine::instance()->register_font("/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf");
    
    Map m(128,128);

    // (1.0,1.0,0.816) land = 
    // (0.62,0.78,0.953) water =

    //m.setBackground(color_factory::from_string("white"));
    m.setBackground( Color(250, 250, 208) );
    
    // create styles

    // Water (polygon)
    feature_type_style waterpoly_style;
    rule_type waterpoly_rule;
    waterpoly_rule.append(polygon_symbolizer(Color(158, 199, 243)));
    waterpoly_rule.append(line_symbolizer(Color(158, 199, 243)));
    waterpoly_style.add_rule(waterpoly_rule);
    m.insert_style("ocean",waterpoly_style);


    // Nationalpark (polygon)
    feature_type_style nps_style;
    rule_type nps_rule;
    polygon_symbolizer nps_fill(Color(0, 150, 0));
    nps_fill.set_opacity(0.2);
    nps_rule.append(nps_fill);
    nps_style.add_rule(nps_rule);
    m.insert_style("usnps",nps_style);


    // Landmass (polygon)
    feature_type_style landpoly_style;
    rule_type landpoly_rule;
    landpoly_rule.append(polygon_symbolizer(Color(250, 250, 208)));
    landpoly_style.add_rule(landpoly_rule);
    m.insert_style("landmass",landpoly_style);


    // Lakes (polygon)
    feature_type_style lakepoly_style;
    rule_type lakepoly_rule;
    lakepoly_rule.set_filter(create_filter("[hyc] = 8 and [f_code] = 'BH000'"));
    lakepoly_rule.append(polygon_symbolizer(Color(158, 199, 243)));
    lakepoly_style.add_rule(lakepoly_rule);
    m.insert_style("lakes",lakepoly_style);


    // Grassland (polygon)
    feature_type_style grasspoly_style;
    rule_type grasspoly_rule;
    grasspoly_rule.append(polygon_symbolizer(Color(208, 250, 208)));
    grasspoly_style.add_rule(grasspoly_rule);
    m.insert_style("grassland",grasspoly_style);


    // Trees (polygon)
    feature_type_style treepoly_style;
    rule_type treepoly_rule;
    treepoly_rule.append(polygon_symbolizer(Color(190, 240, 190)));
    treepoly_style.add_rule(treepoly_rule);
    m.insert_style("trees",treepoly_style);


    // Landice (polygon)
    feature_type_style landice_style;
    rule_type landice_rule;
    //qcdrain_rule.set_filter(create_filter("[HYC] = 8"));
    landice_rule.append(polygon_symbolizer(Color(255, 255, 255)));
    landice_style.add_rule(landice_rule);
    m.insert_style("landice",landice_style);


    // Seaice (shelf) (polygon)
    feature_type_style seaice_style;
    rule_type seaice_rule;
    seaice_rule.set_filter(create_filter("[f_code] = 'BJ065'"));
    seaice_rule.append(polygon_symbolizer(Color(207, 227, 249)));
    seaice_style.add_rule(seaice_rule);
    m.insert_style("seaice",seaice_style);

    // Seaice (pack) (polygon)
    feature_type_style seaice_style2;
    rule_type seaice_rule2;
    seaice_rule2.set_filter(create_filter("[f_code] = 'BJ070'"));
    seaice_rule2.append(polygon_symbolizer(Color(182, 213, 246)));
    seaice_style2.add_rule(seaice_rule2);
    m.insert_style("seaice2",seaice_style);


    // Builtup (polygon)
    feature_type_style builtup_style;
    rule_type builtup_rule;
    //qcdrain_rule.set_filter(create_filter("[HYC] = 8"));
    builtup_rule.append(polygon_symbolizer(Color(208, 208, 208)));
    builtup_style.add_rule(builtup_rule);
    m.insert_style("builtup",builtup_style);


    // Canals (polygon)
    feature_type_style canal_style;
    rule_type canal_rule;
    canal_rule.set_filter(create_filter("[loc] = 8 and ( [exs] = 5  or [exs] = 1 )"));
    canal_rule.append(line_symbolizer(Color(158, 199, 243), 2.0 ));
    canal_style.add_rule(canal_rule);
    m.insert_style("canal",canal_style);

    // Waterways (polygon)
    feature_type_style waterway_style;
    rule_type waterway_rule;
    waterway_rule.set_filter(create_filter("[hyc] = 8"));
    waterway_rule.append(line_symbolizer(Color(126, 159, 194)));
    waterway_style.add_rule(waterway_rule);
    m.insert_style("waterway",waterway_style);

    // intermittent Waterways (polygon)
    feature_type_style iwaterway_style;
    rule_type iwaterway_rule;
    stroke iwaterway_stk (Color(126, 159, 194),1.0);
    iwaterway_stk.add_dash(2, 2);
    iwaterway_rule.set_filter(create_filter("[hyc] = 6"));
    iwaterway_rule.append(line_symbolizer(iwaterway_stk));
    iwaterway_style.add_rule(iwaterway_rule);
    m.insert_style("iwaterway",iwaterway_style);

/*
    // Misc structure (dam etc.) (polyline)
    feature_type_style dam_style;
    rule_type dam_rule;
    dam_rule.append(line_symbolizer(Color(125, 125, 125),3.0));
    dam_style.add_rule(dam_rule);
    m.insert_style("dam",dam_style);
*/

    // Coastline
    feature_type_style coast_style;
    rule_type coast_rule;
    coast_rule.append(line_symbolizer(Color(126, 159, 194),0.1));
    coast_style.add_rule(coast_rule);
    m.insert_style("coast",coast_style);

    // Ferry
    feature_type_style ferry_style;
    rule_type ferry_rule;
    ferry_rule.set_filter(create_filter("[f_code] = 'AQ070'"));
    ferry_rule.append(line_symbolizer(Color(126, 159, 194),2.0));
    ferry_style.add_rule(ferry_rule);
    m.insert_style("ferry",ferry_style);


    // Bridge/Causeway
    feature_type_style causeway_style;
    rule_type causeway_rule;
    causeway_rule.set_filter(create_filter("[f_code] = 'AQ064' and [tuc] = 3"));
    causeway_rule.append(line_symbolizer(Color(126, 159, 194),5.0));
    causeway_rule.append(line_symbolizer(Color(255, 255, 255),3.0));
    causeway_style.add_rule(causeway_rule);
    m.insert_style("causeway",causeway_style);


    // Borders (polyline)
    feature_type_style border1_style;
    /*stroke border1_stk (Color(0,0,0),0.5);
    border1_stk.add_dash(8, 4);
    border1_stk.add_dash(2, 2);
    border1_stk.add_dash(2, 2);*/
    rule_type border1_rule;
    border1_rule.set_filter(create_filter("[use] = 23"));
    //border1_rule.append(line_symbolizer(border1_stk));
    border1_rule.append(line_symbolizer(Color(108,108,108),0.5));
    border1_style.add_rule(border1_rule);
    m.insert_style("border1",border1_style);

    // Borders regional (polyline)
    feature_type_style border2_style;
    rule_type border2_rule;
    border2_rule.set_filter(create_filter("[use] = 26"));
    border2_rule.append(line_symbolizer(Color(108,108,108),0.15));
    border2_style.add_rule(border2_rule);
    m.insert_style("border2",border2_style);


    // Railroads (polyline)
    feature_type_style raillines_style;
    rule_type raillines_rule;
    raillines_rule.set_filter(create_filter("[exs] = 28 or [exs] = 5 or [exs] = 55"));
    stroke raillines_stk( Color(255,255,255), 1.0 );
    raillines_stk.add_dash(3, 3);
    rule_type raillines_rule2;
    raillines_rule.append(line_symbolizer( Color(150,150,150), 2.0) );
    raillines_rule.append( line_symbolizer( raillines_stk ) );
    raillines_style.add_rule(raillines_rule);
    m.insert_style("raillines",raillines_style);

    // Railroadbridge (polyline)
    feature_type_style raillines_bridge_style;
    rule_type raillines_bridge_rule;
    raillines_bridge_rule.set_filter(create_filter("[f_code] = 'AQ064' and [tuc] = 4"));
    raillines_bridge_rule.append(line_symbolizer( Color(126, 159, 194), 2.0) );
    raillines_bridge_rule.append( line_symbolizer( raillines_stk ) );
    raillines_bridge_style.add_rule(raillines_bridge_rule);
    m.insert_style("raillines-bridge",raillines_bridge_style);


    // Roads 1 (The big orange ones, the highways)
    feature_type_style roads1_style_1;
    rule_type roads1_rule_1;
    roads1_rule_1.set_filter(create_filter("[med] = 1"));
    stroke roads1_rule_stk_1(Color(188,149,28),7.0);
    roads1_rule_stk_1.set_line_cap(ROUND_CAP);
    roads1_rule_stk_1.set_line_join(ROUND_JOIN);
    roads1_rule_1.append(line_symbolizer(roads1_rule_stk_1));
    roads1_style_1.add_rule(roads1_rule_1);
    m.insert_style("highway-border", roads1_style_1);

    feature_type_style roads1_style_2;
    rule_type roads1_rule_2;
    roads1_rule_2.set_filter(create_filter("[med] = 1"));
    stroke roads1_rule_stk_2(Color(242,191,36),5.0);
    roads1_rule_stk_2.set_line_cap(ROUND_CAP);
    roads1_rule_stk_2.set_line_join(ROUND_JOIN);
    roads1_rule_2.append(line_symbolizer(roads1_rule_stk_2));
    roads1_style_2.add_rule(roads1_rule_2);
    m.insert_style("highway-fill", roads1_style_2);
   
/*  
    // Roads 3 and 4 (The "grey" roads)
    feature_type_style roads34_style;    
    rule_type roads34_rule;
    roads34_rule.set_filter(create_filter("[CLASS] = 3 or [CLASS] = 4"));
    stroke roads34_rule_stk(Color(171,158,137),2.0);
    roads34_rule_stk.set_line_cap(ROUND_CAP);
    roads34_rule_stk.set_line_join(ROUND_JOIN);
    roads34_rule.append(line_symbolizer(roads34_rule_stk));
    roads34_style.add_rule(roads34_rule);
    
    m.insert_style("smallroads",roads34_style);
*/    

    // Roads 2 (The thin yellow ones)
    feature_type_style roads2_style_1;
    rule_type roads2_rule_1;
    roads2_rule_1.set_filter(create_filter("[med] = 2"));
    stroke roads2_rule_stk_1(Color(171,158,137),4.0);
    roads2_rule_stk_1.set_line_cap(ROUND_CAP);
    roads2_rule_stk_1.set_line_join(ROUND_JOIN);
    roads2_rule_1.append(line_symbolizer(roads2_rule_stk_1));
    roads2_style_1.add_rule(roads2_rule_1);
    m.insert_style("road-border", roads2_style_1);
    
    feature_type_style roads2_style_2;
    rule_type roads2_rule_2;
    roads2_rule_2.set_filter(create_filter("[med] = 2"));
    stroke roads2_rule_stk_2(Color(255,250,115),2.0);
    roads2_rule_stk_2.set_line_cap(ROUND_CAP);
    roads2_rule_stk_2.set_line_join(ROUND_JOIN);
    roads2_rule_2.append(line_symbolizer(roads2_rule_stk_2));
    roads2_style_2.add_rule(roads2_rule_2);
    m.insert_style("road-fill", roads2_style_2);

/*
    // Populated Places
    
    feature_type_style popplaces_style;
    rule_type popplaces_rule;
    text_symbolizer popplaces_text_symbolizer("GEONAME","DejaVu Sans Book",10,Color(0,0,0));
    popplaces_text_symbolizer.set_halo_fill(Color(255,255,200));
    popplaces_text_symbolizer.set_halo_radius(1);
    popplaces_rule.append(popplaces_text_symbolizer);
    popplaces_style.add_rule(popplaces_rule);
    
    m.insert_style("popplaces",popplaces_style );
*/    
    // Layers

    // Landmasses  polygons
    /*
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/grounda";
        
        Layer lyr("Landmass"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("landmass");    
        m.addLayer(lyr);
    }
    */
    
    // Water  polygons
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/oceansea";
        
        Layer lyr("Ocean"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("ocean");    
        m.addLayer(lyr);
    }  
    
    // Shelf- and Packice
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/seaicea";

        Layer lyr("Seaice");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("seaice");
        lyr.add_style("seaice2");
        m.addLayer(lyr);
    }

    // Coastlines
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/coastl";

        Layer lyr("Coastlines");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("coast");    
        m.addLayer(lyr);
    }

    // Grassland  polygons
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/grassa";
        
        Layer lyr("Grassland"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("grassland");    
        m.addLayer(lyr);
    }  
    
    // Trees  polygons
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/treesa";
        
        Layer lyr("Trees"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("trees");    
        m.addLayer(lyr);
    }  
    
    // Lakes  polygons
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/inwatera";
        
        Layer lyr("Lakes"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("lakes");    
        m.addLayer(lyr);
    }  
    
    // Landice
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/landicea";
        
        Layer lyr("Landice"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("landice");    
        m.addLayer(lyr);
    }

    // Builtup
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/builtupa";

        Layer lyr("Built-up Areas");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("builtup");    
        m.addLayer(lyr);
    }

    // Streams
    if(zoom >= 8 ) {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/watrcrsl";

        Layer lyr("Streams");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("waterway");    
        lyr.add_style("iwaterway");    
        m.addLayer(lyr);
    }

    // Regional Borders
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/polbndl";

        Layer lyr("Regional Borders");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("border2");    
        lyr.add_style("border1");    
        m.addLayer(lyr);
    }
  
    // National Parks
    if(zoom >= 0 ) {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/other/nps_boundary";

        Layer lyr("National Parks");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("usnps");    
        m.addLayer(lyr);
    }

    // Canals
    if(zoom >= 8 ) {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/aquecanl";

        Layer lyr("Canals");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("canal");    
        m.addLayer(lyr);
    }

    // Ferry Lines, Railroadbridges, Causeways
    if(zoom >= 8 ) {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/transtrl";

        Layer lyr("Ferry Lines");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("ferry");    
        //lyr.add_style("raillines-bridge");    
        //lyr.add_style("causeway");
        m.addLayer(lyr);
    }

    // Railroads
    if(zoom >= 8 ) {
        {
            parameters p;
            p["type"]="shape";
            p["file"]="../data/shp/railrdl";

            Layer lyr("Railroads");
            lyr.set_datasource(datasource_cache::instance()->create(p));
            lyr.add_style("raillines");    
            m.addLayer(lyr);
	}
    }

    // Roads without median
    if(zoom >= 8 ) {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/roadl";

        Layer lyr("Highway-border");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("road-border");    
        lyr.add_style("road-fill");    
        m.addLayer(lyr);
    }

    // Highways (roads with median)
    if(zoom >= 8 ) {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/shp/roadl";

        Layer lyr("Highway-border");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("highway-border");    
        lyr.add_style("highway-fill");    
        m.addLayer(lyr);
    }


/*
    // Provincial boundaries
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/boundaries_l";
        Layer lyr("Provincial borders"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("provlines");    
        m.addLayer(lyr);
    }
    
    // Roads
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/roads";        
        Layer lyr("Roads"); 
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("smallroads");
        lyr.add_style("road-border");
        lyr.add_style("road-fill");
        lyr.add_style("highway-border");
        lyr.add_style("highway-fill");

        m.addLayer(lyr);        
    }
    // popplaces
    {
        parameters p;
        p["type"]="shape";
        p["file"]="../data/popplaces";
        Layer lyr("Populated Places");
        lyr.set_datasource(datasource_cache::instance()->create(p));
        lyr.add_style("popplaces");    
        m.addLayer(lyr);
    }
*/    
    //m.zoomToBox(Envelope<double>(1105120.04127408,-247003.813399447,
    //                             1906357.31328276,-25098.593149577));
    //m.zoomToBox(Envelope<double>(0,0,90,90));
    
    Image32 buf(m.getWidth(),m.getHeight());

    double bx1,by1,bx2,by2;
    int xx;
    std::string base_dir = "../data/tiles/mapnik";
    std::stringstream fname;

    if( argc == 5 )
    {
        int z = zoom;
        int y = atoi(argv[2]);
        int x = atoi(argv[3]);

	std::cout << "z=" << z << ", y=" << y << ", x=" << x << ", fname=" << argv[4] << std::endl;

	if( x >= 3*(1<<z) ) xx = x - 6*(1<<z); 
	else xx = x;

        bx1 = xx*60.0/(1<<z);
        by1 = 90.0 - ( ((y+1.0)*60.0) / (1<<z) );
        bx2 = (xx+1) * 60.0 / (1<<z);
        by2 = 90.0 - ( (y*60.0) / (1<<z) );

        m.zoomToBox(Envelope<double>(bx1,by1,bx2,by2));

        agg_renderer<Image32> ren(m,buf);
        ren.apply(); 
	
        save_to_file<ImageData32>( argv[4], "png", buf.data() );
    }
    else
    for( int z = 3; z<=6; z++)
    for( int x = 0; x < 6*(1<<z); x++ )
    for( int y = 0; y < 3*(1<<z); y++ )
    {
        fname.str("");
        fname.clear();
        fname << base_dir << (z+1) << "/tile_" << y << "_" << x << ".png";
        std::cout << fname.str() << std::endl;

	if( x >= 3*(1<<z) ) xx = x - 6*(1<<z); 
	else xx = x;

        bx1 = xx*60.0/(1<<z);
        by1 = 90.0 - ( ((y+1.0)*60.0) / (1<<z) );
        bx2 = (xx+1) * 60.0 / (1<<z);
        by2 = 90.0 - ( (y*60.0) / (1<<z) );

        m.zoomToBox(Envelope<double>(bx1,by1,bx2,by2));

        agg_renderer<Image32> ren(m,buf);
        ren.apply(); 
        //save_to_file<ImageData32>("demo.jpg","jpeg",buf.data());
	
        save_to_file<ImageData32>( fname.str(), "png", buf.data() );
    }

    //$file = $dir.'cache/zoom'.$z.'/'.$x.'_'.$y.'_'.$z.'.jpg';

    return EXIT_SUCCESS;
}
