import React from 'react';
import PropTypes from 'prop-types';
import FaBellFull from 'react-icons/lib/fa/bell';
import FaBell from 'react-icons/lib/fa/bell-o';
import { FormattedRelative } from 'react-intl';

import './FactureEchue.scss';

const FactureEchue = ({
  customer,
  deadline1,
  reminder,
  onClick,
  id,
}) => (
  <div className="facture-echue-contain">
    <div className="facture-echue-item">{customer.pro ? customer.customerCompany : customer.lastname}</div>
    <div className="facture-echue-item">
      <FormattedRelative value={new Date(deadline1)} />
    </div>
    { reminder > 0 ? <FaBellFull className="bell" /> : <FaBell className="bell" onClick={onClick(id)} /> }
  </div>
);

FactureEchue.propTypes = {
  customer: PropTypes.object.isRequired,
  deadline1: PropTypes.string.isRequired,
  reminder: PropTypes.number.isRequired,
  onClick: PropTypes.func.isRequired,
  id: PropTypes.number.isRequired,
};

export default FactureEchue;
