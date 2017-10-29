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


const host = "http://visam.interlivre.fr/elastic/visam_elastica"
const searchkit = new SearchkitManager(host)
searchkit.translateFunction = (key) => {
  let translations = {
    "reset.clear_all": "Supprimer les filtres",
    "pagination.previous":"Page précédente",
    "pagination.next":"Page suivante",
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


const HitsGridItem = (props)=> {
  const {bemBlocks, result} = props
  const source:any = extend({}, result._source, result.highlight)
  let url = "http://visam.interlivre.fr/" + result._type + "/" + result._id
  let type = result._type;
  return (
    <div className={type} >
    <div className={bemBlocks.item().mix(bemBlocks.container("_type card"))} data-qa="hit">
      <div className={bemBlocks.item(" card-content")}>
          <h2 data-qa="_type" dangerouslySetInnerHTML={{__html:result._type}}></h2>
        <a href={url} target="_blank">
          <h1 data-qa="nom" className={bemBlocks.item("nom")} dangerouslySetInnerHTML={{__html:source.nom}}></h1>
        </a>
          <h3 data-qa="etablissement" className={bemBlocks.item("etablissement etablissement-name")} dangerouslySetInnerHTML={{__html:source.etablissement}}>
          </h3>
          <div data-qa="discipline" className={bemBlocks.item("discipline")} dangerouslySetInnerHTML={{__html:source.discipline}}>
          </div><br/>
        {/* Effectifs : Formation */}
          {source.niveau &&
            <div>
            <strong>
              Niveau: 
            </strong>
              <span>
                 {source.niveau}
              </span>
            </div>
          }
        {/* Effectifs : Formation */}
          {source.annee > 0 &&
            <div>
            <strong>
              Année:
            </strong>
              <span>
                 {source.annee}
              </span>
            </div>
          }
        {/* Effectifs : Labo & Formation */}
          {source.effectif > 0 &&
            <div>
            <strong>
              Effectif(s):
            </strong>
              <span>
                 {source.effectif}
              </span>
            </div>
          }
          {/* Effectifs : Labo */}
          {source.mailContact &&
            <div>
            <strong>
              Mail :
            </strong>
              <span>
                 {source.mailContact}
              </span>
            </div>
          }
          {/* Sigle : Labo */}
          {source.sigle &&
            <div>
            <strong>
              Sigle :
            </strong>
              <span>
                 {source.sigle}
              </span>
            </div>
          }
          {/* Code : Labo */}
          {source.code &&
            <div>
            <strong>
              Code :
            </strong>
              <span>
                 {source.code}
              </span>
            </div>
          }
          <br/>
          {/* Effectifs : Labo */}
          {source.lien &&
            <a href={source.lien} target="_blank">Lien vers le laboratoire</a>
          }
          {/* Effectifs : Formation */}
          {source.url &&
            <a href={source.url} target="_blank">Lien vers la formation</a>
          }
      </div>
      </div>
    </div>
  )
}

const HitsListItem = (props)=> {
  const {bemBlocks, result} = props
  const source:any = extend({}, result._source, result.highlight)
  let url = "http://visam.interlivre.fr/" + result._type + "/" + result._id
  let type = result._type;
  return (
    <div className={type} >
    <div className={bemBlocks.item().mix(bemBlocks.container("_type card"))} data-qa="hit">
      <div className={bemBlocks.item(" card-content")}>
          <h2 data-qa="_type" dangerouslySetInnerHTML={{__html:result._type}}></h2>
        <a href={url} target="_blank">
          <h1 data-qa="nom" className={bemBlocks.item("nom")} dangerouslySetInnerHTML={{__html:source.nom}}></h1>
        </a>
          <h3 data-qa="etablissement" className={bemBlocks.item("etablissement etablissement-name")} dangerouslySetInnerHTML={{__html:source.etablissement}}>
          </h3>
          <div data-qa="discipline" className={bemBlocks.item("discipline")} dangerouslySetInnerHTML={{__html:source.discipline}}>
          </div><br/>
        {/* Effectifs : Formation */}
          {source.niveau &&
            <div>
            <strong>
              Niveau: 
            </strong>
              <span>
                 {source.niveau}
              </span>
            </div>
          }
        {/* Effectifs : Formation */}
          {source.annee > 0 &&
            <div>
            <strong>
              Année:
            </strong>
              <span>
                 {source.annee}
              </span>
            </div>
          }
        {/* Effectifs : Labo & Formation */}
          {source.effectif > 0 &&
            <div>
            <strong>
              Effectif(s):
            </strong>
              <span>
                 {source.effectif}
              </span>
            </div>
          }
          {/* Effectifs : Labo */}
          {source.mailContact &&
            <div>
            <strong>
              Mail :
            </strong>
              <span>
                 {source.mailContact}
              </span>
            </div>
          }
          {/* Sigle : Labo */}
          {source.sigle &&
            <div>
            <strong>
              Sigle :
            </strong>
              <span>
                 {source.sigle}
              </span>
            </div>
          }
          {/* Code : Labo */}
          {source.code &&
            <div>
            <strong>
              Code :
            </strong>
              <span>
                 {source.code}
              </span>
            </div>
          }
          <br/>
          {/* Effectifs : Labo */}
          {source.lien &&
            <a href={source.lien} target="_blank">Lien vers le laboratoire</a>
          }
          {/* Effectifs : Formation */}
          {source.url &&
            <a href={source.url} target="_blank">Lien vers la formation</a>
          }
      </div>
      </div>
    </div>
  )
}


class App extends Component {
  render() {
    return (
      <SearchkitProvider searchkit={searchkit}>
        <Layout>
          <TopBar>
            <SearchBox placeholder="Rechercher" autofocus={true} searchOnChange={true} prefixQueryFields={["nom^2","description","discipline"]}/>
          </TopBar>

        <LayoutBody>

          <SideBar>
            <RefinementListFilter id="_type" title="Type" field="_type" operator="OR" listComponent={ItemHistogramList}/>
            <RefinementListFilter id="etablissement" title="Établissements" field="etablissement" operator="OR" listComponent={ItemList}/>
            <RefinementListFilter size="12" id="discipline" title="Disciplines" field="discipline" operator="OR"/>
            <RefinementListFilter listComponent={PieFilterList} id="annee" title="Annee" field="annee" operator="OR"/>
            <DynamicRangeFilter field="effectif" id="effectif" title="Effectif"/>
            <GeoMap/>


          </SideBar>

          <LayoutResults>

            <ActionBar>
              <ActionBarRow>
                <HitsStats/>
                <ViewSwitcherToggle/>
                <SortingSelector options={[
                  {label:"Pertinence", field:"_score", order:"desc"},
                  {label:"Par année", field:"annee", order:"desc"},
                  {label:"Par effectif", field:"effectif", order:"desc"}
                ]}/>
              </ActionBarRow>
              <ActionBarRow>
                <GroupedSelectedFilters/>
                <ResetFilters/>
              </ActionBarRow>
            </ActionBar>

            <ViewSwitcherHits
                hitsPerPage={12} highlightFields={["nom","description"]}
                sourceFilter={["nom", "description", "niveau", "type","discipline","etablissement",'geo', 'annee', 'effectif', 'niveau', 'url', 'lien', 'mailContact', 'sigle','code']}
                hitComponents={[
                  {key:"list", title:"Liste", itemComponent:HitsListItem, defaultOption:true},
                  {key:"grid", title:"Grille", itemComponent:HitsGridItem},
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