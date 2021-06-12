import { connect } from "react-redux";
import { withRouter } from "react-router-dom";

import { DataTypes } from "../../data/Types";
import { DataGetter } from "../../data/DataGetter";
import { getData} from "../../data/ActionCreators";
import TransactionsDisplay from "./TransactionsDisplay";
import ApiResultConverter, {ApiResultFilter, UrlToIriConverter} from "../../data/ApiResultConverter";

export default function SettingsConnector() {
  const mapStateToProps = (storeData, ownProps) => {
    let subcategoryUrl = ownProps.match.params.subcategory;
    let transactions;
    if (subcategoryUrl) {
      transactions = ApiResultFilter.filterTransactionsForSubcategory(storeData,
        UrlToIriConverter.findIriForSubcategoryUrl(storeData, ownProps));
    } else {
      transactions = ApiResultFilter.filterTransactionsForCategory(storeData,
        UrlToIriConverter.findIriForCategoryUrl(storeData, ownProps));
    }
    transactions = ApiResultConverter.replaceIriByObjectInTransactions(storeData, transactions);
    return {
      transactions: transactions,
      icons: storeData.modelData[DataTypes.ICONS],
    };
  };

  const mapDispatchToProps = (dispatch, ownProps) => ({
    getData: (type) => dispatch(getData(type))
  });

  const mergeProps = (dataProps, functionProps, ownProps) => {
    let categoryUrl = ownProps.match.params.category;
    let subcategoryUrl = ownProps.match.params.subcategory;
    let routedDispatchers;
    if (subcategoryUrl) {
      routedDispatchers = {
        editCallback: (target) =>
          ownProps.history.push(`/${categoryUrl}/${subcategoryUrl}/edit/${target['@id']}`),
        getData: functionProps.getData,
      };
    } else {
      routedDispatchers = {
        editCallback: (target) =>
          ownProps.history.push(`/${categoryUrl}/edit/${target['@id']}`),
        getData: functionProps.getData,
      };
    }
    return Object.assign({}, dataProps, routedDispatchers, ownProps);
  };

  return withRouter(connect(mapStateToProps, mapDispatchToProps, mergeProps)(
    DataGetter(DataTypes.TRANSACTIONS, TransactionsDisplay)));
}
