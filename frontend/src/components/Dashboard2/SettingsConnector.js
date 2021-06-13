import { connect } from "react-redux";
import { withRouter } from "react-router-dom";

import { DataTypes } from "../../data/Types";
import { DataGetter } from "../../data/DataGetter";
import { getData } from "../../data/ActionCreators";
import SettingsDisplay from "./SettingsDisplay";

export default function SettingsConnector() {
  const mapStateToProps = (storeData, ownProps) => {
    return {
      categories: storeData.modelData[DataTypes.CATEGORIES],
      subcategories: storeData.modelData[DataTypes.SUBCATEGORIES],
      settlementAccounts: storeData.modelData[DataTypes.SETTLEMENT_ACCOUNTS],
      methodOfPayments: storeData.modelData[DataTypes.METHOD_OF_PAYMENTS],
      icons: storeData.modelData[DataTypes.ICONS],
    };
  };

  const mapDispatchToProps = (dispatch, ownProps) => ({
    getData: (type) => dispatch(getData(type))
  });

  const mergeProps = (dataProps, functionProps, ownProps) => {
    let routedDispatchers = {
      editCallback: (target) =>
        ownProps.history.push(`/edit/${target['@id']}`),
      getData: functionProps.getData
    };
    return Object.assign({}, dataProps, routedDispatchers, ownProps);
  };

  return withRouter(connect(mapStateToProps, mapDispatchToProps, mergeProps)(
    DataGetter(DataTypes.TRANSACTIONS, SettingsDisplay)));
}

