import { connect } from "react-redux";

import { deleteData, getData, saveData } from "../../data/ActionCreators";
import { DataTypes } from "../../data/Types";
import { withRouter } from "react-router-dom";
import { DataGetter } from "../../data/DataGetter";
import ApiResultConverter, {ApiResultFilter, UrlToIriConverter} from "../../data/ApiResultConverter";

export const EditorConnector = (dataType, presentationComponent) => {
  const mapStateToProps = (storeData, ownProps) => {
    const mode = ownProps.match.params.mode;
    const dataType = ownProps.match.params.datatype;
    const iri = UrlToIriConverter.findIriForEditUrl(ownProps);

    let transaction;
    if (mode === "edit" && dataType === "transactions") {
      transaction = ApiResultFilter.findOneTransaction(storeData, iri);
      transaction = ApiResultConverter.replaceIriByObjectInTransaction(storeData, transaction);
    }

    let category;
    if (mode === "edit" && dataType === "categories") {
      category = ApiResultFilter.findOneCategory(storeData, iri);
    }

    let settlementAccount;
    if (mode === "edit" && dataType === "settlement_accounts") {
      settlementAccount = ApiResultFilter.findOneSettlementAccount(storeData, iri);
    }

    let methodOfPayment;
    if (mode === "edit" && dataType === "method_of_payments") {
      methodOfPayment = ApiResultFilter.findOneMethodOfPayment(storeData, iri);
    }

    let subcategory;
    if (mode === "edit" && dataType === "subcategories") {
      subcategory = ApiResultFilter.findOneSubcategory(storeData, iri);
    }

    return {
      editing: mode === "edit" || mode === "create",

      transaction: transaction,
      subcategory: subcategory,
      category: category,
      settlementAccount: settlementAccount,
      methodOfPayment: methodOfPayment,

      settlementAccounts: storeData.modelData[DataTypes.SETTLEMENT_ACCOUNTS],
      currencies: storeData.modelData[DataTypes.CURRENCIES],
      subcategories: storeData.modelData[DataTypes.SUBCATEGORIES],
      methodOfPayments: storeData.modelData[DataTypes.METHOD_OF_PAYMENTS],
      icons: storeData.modelData[DataTypes.ICONS],
      categories: storeData.modelData[DataTypes.CATEGORIES]
    }
  };

  const mapDispatchToProps = (dispatch) => ({
    saveCallback: (data) => dispatch(saveData(dataType, data)),
    getData: (type) => dispatch(getData(type)),
    deleteCallback: (target) => dispatch(deleteData(dataType, target))
  });

  const mergeProps = (dataProps, functionProps, ownProps) => {
    let routedDispatchers = {
      cancelCallback: () => ownProps.history.goBack(),
      saveCallback: (data) => {
        functionProps.saveCallback(data);
        ownProps.history.goBack();
      },
      getData: functionProps.getData,
      deleteCallback: (target) => {
        functionProps.deleteCallback(target);
        ownProps.history.goBack();
      },
    };
    return Object.assign({}, dataProps, routedDispatchers, ownProps);
  }

  return withRouter(connect(mapStateToProps, mapDispatchToProps, mergeProps)(DataGetter(DataTypes.TRANSACTIONS, presentationComponent)));
};
