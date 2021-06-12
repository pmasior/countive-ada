import { connect } from "react-redux";
import { withRouter } from "react-router-dom";

import { DataTypes } from "../../data/Types";
import { DataGetter } from "../../data/DataGetter";
import { getData } from "../../data/ActionCreators";
import SubcategoryDisplay from "../Dashboard2/SubcategoryDisplay";
import ApiResultConverter, {ApiResultFilter, UrlToIriConverter} from "../../data/ApiResultConverter";

export default function SubcategoryConnector() {
  const mapStateToProps = (storeData, ownProps) => {
    let categoryUrl = ownProps.match.params.category
    let subcategories = ApiResultFilter.filterSubcategoriesForCategory(storeData,
        UrlToIriConverter.findIriForCategoryUrl(storeData, ownProps));
    subcategories = ApiResultConverter.replaceIriByObjectInSubcategory(storeData, subcategories);
    return {
      categoryUrl: categoryUrl,
      subcategories: subcategories,
      icons: storeData.modelData[DataTypes.ICONS],
    }
  }

  const mapDispatchToProps = (dispatch, ownProps) => ({
    getData: (type) => dispatch(getData(type))
  });

  return withRouter(connect(mapStateToProps, mapDispatchToProps)(
    DataGetter(DataTypes.SUBCATEGORIES, SubcategoryDisplay)))
}
