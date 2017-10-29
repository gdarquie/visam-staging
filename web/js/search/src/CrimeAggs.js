var require= null;

import * as React from "react"
import {GoogleMapLoader, GoogleMap, Marker} from "react-google-maps";
import { map, debounce, min } from 'lodash'
import {default as ScriptjsLoader} from "react-google-maps/lib/async/ScriptjsLoader";

import {
  Accessor,
  AggsContainer,
  SearchkitComponent,
  FilterBucket,
  Utils,
  GeohashBucket,
  GeoBoundsMetric,
  SignificantTermsBucket,
  FilteredQuery,
  BoolQueries,
  BoolShould,
  BoolMust
} from "searchkit"

const Carte = ()=> {  
  return (
    <GeoMap/>
  )
}


export class CrimeAccessor extends Accessor{
  area:any
  precision:number = 6
  setArea(area){
    this.area = area
  }
  setPrecision(precision){
    this.precision = precision
  }

  setResults(results){
    super.setResults(results)
     let significant = map(
      this.getAggregations(["geo", "significant", "buckets"], [])
    , "key")
    console.log("significant", significant)
  }

  buildSharedQuery(query){
    if(this.area){
      return query.addQuery({bool :{
        filter:{
          geo_bounding_box:{
            geo:this.area
          }
        }
      }})
    }
    return query
  }

  buildOwnQuery(query){
    return query.setAggs(FilterBucket(
      "geo", query.getFilters(),
      GeohashBucket(
        "areas", "geo",
        {precision:this.precision, size:100},
        GeoBoundsMetric("cell", "geo")
      ),
      SignificantTermsBucket("significant","etablissement", {size:2}),
      GeoBoundsMetric("bounds", "geo")
    ))
  }
}

declare var google:any


export class GeoMap extends SearchkitComponent<any, any> {
  map:any
  accessor:CrimeAccessor
  constructor(){
    super()
  }
  defineAccessor(){
    return new CrimeAccessor()
  }

  geoPointToLatLng(point){
    return new google.maps.LatLng(point.lat, point.lon)
  }
  setBounds(){
    let bounds = new google.maps.LatLngBounds()
    let data = (this.accessor.getAggregations(["geo", "bounds", "bounds"], null))
    if(data){
      bounds.extend(this.geoPointToLatLng(data.top_left))
      bounds.extend(this.geoPointToLatLng(data.bottom_right))
    }
    this.map.fitBounds(bounds)
  }
  centerFromBound(bound){
    return {
      lat:(bound.top_left.lat + bound.bottom_right.lat)/2,
      lng:(bound.top_left.lon + bound.bottom_right.lon)/2
    }
  }
  getMarkers(){
    let areas = this.accessor.getAggregations(["geo", "areas", "buckets"], [])

    let markers =  map(areas, (area)=> {
      return {
        position:this.centerFromBound(area["cell"].bounds),
        key:area["key"],
        title:area["doc_count"] +""
      }
    })
    return markers
  }

  onBoundsChanged(event){
    console.log("onBoundsChanged")
    let bounds = this.map.getBounds()
    let ne = bounds.getNorthEast()
    let sw = bounds.getSouthWest()
    let area = {
      top_right:{ lat:ne.lat(), lon:ne.lng() },
      bottom_left:{ lat:sw.lat(), lon:sw.lng() }
    }
    this.accessor.setPrecision(min([10, this.map.getZoom()-1]))
    this.accessor.setArea(area)
    this.searchkit.search()
  }
  onCenterChanged(event){
    console.log("onCenterChanged", event)
  }
  onZoomChanged(event){
    console.log("onZoomChanged", event)
  }

  render(){
    setTimeout(()=> {
      if(!this.accessor.area){
        this.setBounds()
      }
    })
    let timesCalled = 0
    let fn = debounce(this.onBoundsChanged.bind(this), 500)
    let onBoundsChanged = ()=> {
      if(timesCalled > 0){
        fn()
      }else {
        timesCalled++
      }
    }
    let styleMapLight = [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"administrative.locality","elementType":"labels.text","stylers":[{"visibility":"on"},{"saturation":"-3"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#c30d26"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ff0023"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ff0023"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"poi.school","elementType":"geometry.fill","stylers":[{"color":"#c30d26"},{"saturation":"0"},{"visibility":"off"},{"lightness":"79"},{"gamma":"4.27"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#ff0023"},{"saturation":"100"},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#c30d26"},{"saturation":"0"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#ff0023"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#c30d26"},{"saturation":"0"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#ff0023"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#ff0023"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#ff0023"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#0098ff"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}]
    let styleMapHeavy = [{"featureType":"all","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"all","elementType":"labels.text","stylers":[{"color":"#444444"}]},{"featureType":"administrative","elementType":"labels.text","stylers":[{"weight":"2"}]},{"featureType":"administrative.country","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"administrative.country","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"all","stylers":[{"visibility":"simplified"},{"saturation":"-100"},{"lightness":"30"}]},{"featureType":"administrative.locality","elementType":"labels.text","stylers":[{"weight":"2"},{"color":"#000000"}]},{"featureType":"administrative.neighborhood","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text","stylers":[{"visibility":"on"},{"color":"#919191"},{"weight":"0.69"}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text","stylers":[{"color":"#bababa"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"simplified"},{"gamma":"0.00"},{"lightness":"74"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#ff0000"},{"saturation":"-15"},{"lightness":"40"},{"gamma":"1.25"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.text","stylers":[{"saturation":"0"},{"visibility":"on"},{"weight":"0.01"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"saturation":"0"},{"lightness":"60"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"lightness":"75"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#ff0000"},{"lightness":"80"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#efefef"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]}]
    return (
      <section id="map" style={{width: '100%', height: "400px"}}>
       <GoogleMapLoader
         containerElement={
           <div
             {...this.props}
             style={{
               height: "100%",
             }}
           />
         }
         googleMapElement={
           <GoogleMap
            onBoundsChanged={onBoundsChanged}
            defaultOptions={{ styles: styleMapHeavy }}
             ref={(map) => this.map = map}>
             {
               map(this.getMarkers(), (marker)=>{
                 return <Marker {...marker}/>
               })
             }
           </GoogleMap>
         }
       />
      </section>
    )
  }

}