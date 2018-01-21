import React, { Component } from 'react'
import { extend } from 'lodash'
import { SearchkitManager,SearchkitProvider,
  SearchBox, RefinementListFilter, Pagination,
  HierarchicalMenuFilter, HitsStats, SortingSelector, NoHits,
  ResetFilters, RangeFilter, NumericRefinementListFilter,
  ViewSwitcherHits, ViewSwitcherToggle, DynamicRangeFilter,
  InputFilter, GroupedSelectedFilters,
  Layout, TopBar, LayoutBody, LayoutResults,
  ActionBar, ActionBarRow, SideBar, SearchkitComponent, ItemList, ItemHistogramList } from 'searchkit'

import { PieFilterList } from "searchkit-recharts"



import {
  CrimeAccessor,
  GeoMap,
  Carte
} from "./CrimeAggs"

import GoogleMapReact from 'google-map-react';

class SimpleMap extends SearchkitComponent {
  static defaultProps = {
    center: {lat: 59.95, lng: 30.33},
    zoom: 11
  };
  render() {
    return (
    <div style={{width: '100%', height: '400px'}}>
      <GoogleMapReact
        bootstrapURLKeys={{key: "AIzaSyB-xVtrt5MG5-Ym3bZvezFY35Xx1xdEMI4"}}
        defaultCenter={this.props.center}
        defaultZoom={this.props.zoom}
      >
      </GoogleMapReact>
    </div>

    );
  }
}


//const host = "http://staging.visam.interlivre.fr/elastic/visam_elastica"
const host = "http://localhost:9200/visam_elastica"
const searchkit = new SearchkitManager(host)
searchkit.translateFunction = (key) => {
  let translations = {
    "reset.clear_all": "Supprimer les filtres",
    "facets.view_more": "Voir plus",
    "facets.view_less":"Voir moins",
    "facets.view_all" : "Voir tous",
    "NoHits.NoResultsFound" : "Pas de résultats pour {query}",
    "NoHits.DidYouMean" :"Rechercher {suggestion}.",
    "NoHits.SearchWithoutFilters" : "Recherche {query} sans filtres",
    "NoHits.NoResultsFoundDidYouMean" : "Pas de résultats {query}. Voulez vous dire {suggestion}?",
    "hitstats.results_found" : "{hitCount} résultats trouvés en {timeTaken}ms",
    "pagination.previous" : "Précédent",
    "pagination.next" : "Suivant",
    "searchbox.placeholder" : "Recherche"
  }
  return translations[key]
}

const HitsListItem = (props)=> {
  const {bemBlocks, result} = props;
  const source:any = extend({}, result._source, result.highlight);
  let url ="/" + result._type + "/" + result._id;
  let imagepath = "/img/"+ result._type + ".svg";
  let type = result._type;
  return (
    <div className={type} >
    <div className={bemBlocks.item().mix(bemBlocks.container("_type "))} data-qa="hit">
      <div className={bemBlocks.item("notice notice petit resultat {type}")}>
        <div className={bemBlocks.item(" type")}>
          <img src={imagepath} alt="logo" />
          <h4 data-qa="_type" dangerouslySetInnerHTML={{__html:result._type}}></h4>
          {source.niveau &&
              <span>
                 - {source.niveau}
              </span>
          }
          {source.sigle &&
              <span>
                 - <span data-qa="_sigle" dangerouslySetInnerHTML={{__html:source.sigle}}></span>
              </span>
          }
        </div>
        <a href={url} target="_blank">
          <h1 data-qa="nom" className={bemBlocks.item("nom")} dangerouslySetInnerHTML={{__html:source.nom}}></h1>
        </a>
          <h3 data-qa="etablissement" className={bemBlocks.item("etablissement etablissement-name")} dangerouslySetInnerHTML={{__html:source.etablissement}}>
          </h3>
          <section>
          {source.hesamette > 0 &&
            <h5><i class="material-icons dp48">label</i> Discipline</h5>
          }
          <div data-qa="hesamette" className={bemBlocks.item("hesamette")} dangerouslySetInnerHTML={{__html:source.hesamette}}></div>
          </section>
      </div>

      </div>
      
    </div>
  )
}

const highlightCustom = {"fields" : {"_all" : { "pre_tags" : ["<em>"], "post_tags" : ["</em>"] }, "nom" : {"force_source" : true}, "hesamette" : {"force_source" : true},"sigle" : {} }};
const multiMatch = {"fields": [ "nom", "message" ]};
class App extends Component {
  render() {
    return (
      <SearchkitProvider searchkit={searchkit}>
        <Layout>
          <TopBar>
            <SearchBox placeholder="Rechercher" autofocus={true} searchOnChange={true}  prefixQueryFields={["nom^5", "_all"]}/>
          </TopBar>

        <LayoutBody>

          <SideBar>
            <RefinementListFilter id="_type" title="Type" field="_type" operator="OR" listComponent={ItemList}/>
            <RefinementListFilter id="etablissement" title="Établissements" field="etablissement" operator="OR" listComponent={ItemList}/>
            <RefinementListFilter size="12" id="hesamette" title="Disciplines" field="hesamette" operator="OR"/>
            <RefinementListFilter size="12" id="geo" title="geo" field="geo" operator="OR"/>
          </SideBar>

          <LayoutResults>

            <ActionBar>
              <ActionBarRow>
                <HitsStats/>
                <SortingSelector options={[
                  {label:"Pertinence", field:"_score", order:"desc"},
                  {label:"Par année", field:"annee", order:"desc"}
                ]}/>
              </ActionBarRow>
              <ActionBarRow>
                <GroupedSelectedFilters/>
                <ResetFilters/>
              </ActionBarRow>
            </ActionBar>

            <ViewSwitcherHits
                hitsPerPage={12}
                customHighlight={highlightCustom}
                sourceFilter={["nom", "description", "niveau", "type","discipline","hesamette","etablissement",'geo', 'annee', 'effectif', 'niveau', 'url', 'lien', 'mailContact', 'sigle','code']}
                hitComponents={[
                  {key:"list", title:"Liste", itemComponent:HitsListItem, defaultOption:true},
                ]}
                scrollTo="body"
            />
            <NoHits suggestionsField="nom"/>
            <Pagination showNumbers={true}/>
          </LayoutResults>
          </LayoutBody>
        </Layout>
      </SearchkitProvider>
      

      
    );
  }
}

export default App;